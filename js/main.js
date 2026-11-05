// ===== 1. Hàm tiện ích =====
// Định dạng số thành tiền Việt: 250000 -> "250.000 đ"
function formatPrice(amount) {
    return amount.toLocaleString("vi-VN") + " đ";
}

const contactForm = document.querySelector('#contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', function (event) {
        const message = contactForm.querySelector('#message');
        const error = contactForm.querySelector('#message-error');
        if (message.value.trim().length < 10) {
            event.preventDefault();
            error.textContent = 'Nội dung liên hệ phải có ít nhất 10 ký tự.';
            message.focus();
        } else error.textContent = '';
    });
}

// Preview stays local until the profile form is saved. Server validates uploads again.
const avatarInput = document.querySelector('#avatar');
const avatarPreview = document.querySelector('#avatar-preview');
if (avatarInput && avatarPreview) {
    const image = document.querySelector('#avatar-preview-image');
    const initials = document.querySelector('#avatar-preview-initials');
    const error = document.querySelector('#avatar-error');
    const status = document.querySelector('.avatar-preview-status');
    const remove = document.querySelector('#remove-avatar');
    const reset = document.querySelector('#avatar-reset');
    let previewUrl;
    let selectionVersion = 0;
    function clearPreview() {
        selectionVersion++;
        if (previewUrl) URL.revokeObjectURL(previewUrl);
        previewUrl = null;
    }
    function showSaved() {
        const saved = avatarPreview.dataset.savedAvatar;
        const removing = remove && remove.checked;
        image.hidden = !saved || removing;
        initials.hidden = Boolean(saved) && !removing;
        if (saved) image.src = saved;
    }
    function clearFile() {
        clearPreview();
        avatarInput.value = '';
        avatarInput.setCustomValidity('');
        avatarInput.removeAttribute('aria-invalid');
        error.textContent = '';
        reset.hidden = true;
        showSaved();
    }
    function rejectFile(message) {
        avatarInput.setCustomValidity(message);
        avatarInput.setAttribute('aria-invalid', 'true');
        error.textContent = message;
        status.textContent = '';
        showSaved();
    }
    avatarInput.addEventListener('change', async function () {
        clearPreview();
        const version = selectionVersion;
        avatarInput.setCustomValidity('');
        avatarInput.removeAttribute('aria-invalid');
        error.textContent = '';
        const file = avatarInput.files[0];
        reset.hidden = !file;
        if (!file) { showSaved(); status.textContent = ''; return; }
        if (remove) remove.checked = false;
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            rejectFile('Chỉ chấp nhận ảnh JPG, PNG hoặc WebP hợp lệ.'); return;
        }
        if (file.size > 2 * 1024 * 1024 || !file.size) {
            rejectFile('Ảnh đại diện phải có dung lượng từ 1 byte đến 2 MB.'); return;
        }
        previewUrl = URL.createObjectURL(file);
        const candidate = new Image();
        candidate.src = previewUrl;
        try {
            await candidate.decode();
            if (version !== selectionVersion) return;
            if (candidate.naturalWidth > 4096 || candidate.naturalHeight > 4096) {
                rejectFile('Chiều rộng và chiều cao ảnh không được vượt quá 4096 pixel.'); return;
            }
            image.src = previewUrl;
            image.hidden = false;
            initials.hidden = true;
            status.textContent = 'Đang xem trước ảnh mới. Nhấn Lưu thay đổi để cập nhật.';
        } catch (failure) {
            if (version === selectionVersion) rejectFile('Không đọc được ảnh. Vui lòng chọn ảnh khác.');
        }
    });
    reset.addEventListener('click', function () {
        clearFile();
        status.textContent = 'Đã bỏ ảnh vừa chọn. Ảnh đã lưu vẫn được giữ nguyên.';
        avatarInput.focus();
    });
    if (remove) remove.addEventListener('change', function () {
        clearFile();
        status.textContent = remove.checked ? 'Ảnh đại diện sẽ được xóa sau khi lưu thay đổi.' : '';
    });
    showSaved();
    window.addEventListener('pagehide', clearPreview);
}
const errorSummary = document.querySelector('[data-error-summary]');
if (errorSummary) errorSummary.focus();

// Add products in place; keep the native form as a no-JavaScript fallback.
const cartNotification = document.querySelector('#cart-notification');
if (cartNotification && window.fetch && window.FormData) {
    let addingToCart = false;
    const message = cartNotification.querySelector('.cart-notification-message');
    const icon = cartNotification.querySelector('.cart-notification-icon');
    const close = cartNotification.querySelector('.cart-notification-close');
    let notificationTimer;
    function hideCartNotification() {
        clearTimeout(notificationTimer);
        cartNotification.hidden = true;
        message.textContent = '';
    }
    function scheduleNotificationDismiss() {
        clearTimeout(notificationTimer);
        if (!cartNotification.hidden && !cartNotification.matches(':hover') &&
            !cartNotification.contains(document.activeElement)) {
            notificationTimer = setTimeout(hideCartNotification, 2000);
        }
    }
    function notifyCart(text, success) {
        cartNotification.hidden = false;
        cartNotification.classList.toggle('is-error', !success);
        icon.textContent = success ? '✓' : '!';
        message.textContent = text;
        scheduleNotificationDismiss();
    }
    // Give customers time to use the link or close button while interacting.
    cartNotification.addEventListener('pointerenter', function () { clearTimeout(notificationTimer); });
    cartNotification.addEventListener('pointerleave', scheduleNotificationDismiss);
    cartNotification.addEventListener('focusin', function () { clearTimeout(notificationTimer); });
    cartNotification.addEventListener('focusout', function (event) {
        if (!cartNotification.contains(event.relatedTarget)) setTimeout(scheduleNotificationDismiss, 0);
    });
    close.addEventListener('click', function () {
        const cartLink = document.querySelector('.nav-cart');
        if (cartLink) cartLink.focus();
        hideCartNotification();
    });
    document.querySelectorAll('[data-add-to-cart]').forEach(function (form) {
        form.addEventListener('submit', async function (event) {
            event.preventDefault();
            if (addingToCart) return;
            addingToCart = true;
            const data = new FormData(form);
            const button = form.querySelector('button[type=submit]');
            const originalText = button.textContent;
            const availableButtons = [...document.querySelectorAll('[data-add-to-cart] button[type=submit]:not(:disabled)')];
            availableButtons.forEach(function (item) { item.disabled = true; });
            form.setAttribute('aria-busy', 'true');
            button.textContent = 'Đang thêm…';
            try {
                const response = await fetch(form.action, {
                    method: 'POST', body: data, credentials: 'same-origin',
                    headers: {Accept: 'application/json'}, redirect: 'error'
                });
                const result = await response.json();
                if (typeof result.message !== 'string' || typeof result.success !== 'boolean') throw new Error('Invalid cart response');
                if (Number.isSafeInteger(result.cart_count) && result.cart_count >= 0) {
                    const badge = document.querySelector('#cart-count');
                    if (badge) badge.textContent = String(result.cart_count);
                    const cartLink = document.querySelector('.nav-cart');
                    if (cartLink) cartLink.setAttribute('aria-label', 'Giỏ hàng, ' + result.cart_count + ' sản phẩm');
                }
                notifyCart(result.message, response.ok && result.success);
            } catch (failure) {
                // Do not retry automatically: a lost response may still have added the product.
                notifyCart('Chưa xác nhận được kết quả thêm sản phẩm. Vui lòng kiểm tra giỏ hàng trước khi thử lại.', false);
            } finally {
                addingToCart = false;
                availableButtons.forEach(function (item) { item.disabled = false; });
                button.textContent = originalText;
                form.removeAttribute('aria-busy');
            }
        });
    });
}

// ===== 3. Trang giỏ hàng: tự tính thành tiền và tổng cộng =====
function updateCartTotals(table) {
    let total = 0;
    table.querySelectorAll("tbody tr").forEach(function (row) {
        const price = Number(row.dataset.price);
        const qty = Number(row.querySelector(".qty").value);
        const lineTotal = price * qty;
        row.querySelector(".line-total").textContent = formatPrice(lineTotal);
        total += lineTotal;
    });
    document.querySelector("#cart-total").textContent = formatPrice(total);
}

const cartTable = document.querySelector(".cart-table");
if (cartTable) {
    // Tính lại mỗi khi người dùng đổi số lượng ở bất kỳ ô nào trong bảng
    cartTable.addEventListener("input", function () {
        updateCartTotals(cartTable);
    });
    // Tính lần đầu khi trang vừa mở
    updateCartTotals(cartTable);
}

// ===== 4. Form đăng ký: hai mật khẩu phải khớp nhau =====
const registerForm = document.querySelector("#register-form");
if (registerForm) {
    registerForm.addEventListener("submit", function (event) {
        const password = document.querySelector("#password").value;
        const password2 = document.querySelector("#password2").value;
        const error = document.querySelector("#password-error");

        if (password !== password2) {
            event.preventDefault();
            error.textContent = "Hai mật khẩu không khớp nhau.";
            document.querySelector('#password2').setAttribute('aria-invalid', 'true');
            document.querySelector('#password2').focus();
        } else {
            error.textContent = "";
            document.querySelector('#password2').removeAttribute('aria-invalid');
        }
    });
}

// Giữ mật khẩu có thể dán và tương thích với trình quản lý mật khẩu.
document.querySelectorAll('.password-toggle').forEach(function (button) {
    const input = document.getElementById(button.getAttribute('aria-controls'));
    if (!input) return;
    const label = button.getAttribute('aria-label');
    button.addEventListener('click', function () {
        const visible = input.type === 'password';
        input.type = visible ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(visible));
        button.setAttribute('aria-label', visible ? label.replace('Hiện', 'Ẩn') : label);
    });
});

const menuToggle = document.querySelector('.menu-toggle');
const mainNavigation = document.querySelector('#main-navigation');
const accountMenu = document.querySelector('#account-menu');
if (accountMenu) {
    const avatarToggle = accountMenu.querySelector('summary');
    avatarToggle.setAttribute('aria-expanded', String(accountMenu.open));
    accountMenu.addEventListener('toggle', function () {
        avatarToggle.setAttribute('aria-expanded', String(accountMenu.open));
        if (accountMenu.open && menuToggle && mainNavigation) {
            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.setAttribute('aria-label', 'Mở menu điều hướng');
            mainNavigation.classList.remove('is-open');
        }
    });
    avatarToggle.addEventListener('keydown', function (event) {
        if (event.key === 'ArrowDown') {
            event.preventDefault();
            accountMenu.open = true;
            accountMenu.querySelector('.account-menu-links a').focus();
        }
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && accountMenu.open) {
            event.preventDefault();
            accountMenu.open = false;
            avatarToggle.focus();
        }
    });
    document.addEventListener('pointerdown', function (event) {
        if (!accountMenu.contains(event.target)) accountMenu.open = false;
    });
    document.addEventListener('focusin', function (event) {
        if (!accountMenu.contains(event.target)) accountMenu.open = false;
    });
    accountMenu.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () { accountMenu.open = false; });
    });
}
if (menuToggle && mainNavigation) {
    document.documentElement.classList.add('nav-enhanced');
    function setMenu(open) {
        menuToggle.setAttribute('aria-expanded', String(open));
        menuToggle.setAttribute('aria-label', open ? 'Đóng menu điều hướng' : 'Mở menu điều hướng');
        mainNavigation.classList.toggle('is-open', open);
    }
    menuToggle.addEventListener('click', function () {
        if (accountMenu) accountMenu.open = false;
        setMenu(menuToggle.getAttribute('aria-expanded') !== 'true');
    });
    mainNavigation.addEventListener('click', function (event) {
        if (event.target.closest('a')) setMenu(false);
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && menuToggle.getAttribute('aria-expanded') === 'true') {
            setMenu(false);
            menuToggle.focus();
        }
    });
    window.matchMedia('(min-width: 901px)').addEventListener('change', function () { setMenu(false); });
}

let confirmationDialog;
document.querySelectorAll('[data-copy]').forEach(function (button) {
    button.addEventListener('click', async function () {
        const status = document.querySelector('.payment-copy-status');
        try {
            await navigator.clipboard.writeText(button.dataset.copy);
            if (status) status.textContent = 'Đã sao chép: ' + button.dataset.copy;
        } catch (error) {
            if (status) status.textContent = 'Bạn có thể chọn và sao chép thủ công: ' + button.dataset.copy;
        }
    });
});

let confirmationResult;
let approvedForm;
let approvedSubmitter;

function confirmAction(message) {
    if (!confirmationDialog) {
        confirmationDialog = document.createElement("dialog");
        confirmationDialog.className = "confirm-dialog";
        confirmationDialog.setAttribute("aria-labelledby", "confirm-title");
        confirmationDialog.setAttribute("aria-describedby", "confirm-message");
        confirmationDialog.innerHTML = `
            <div class="confirm-dialog__icon" aria-hidden="true">!</div>
            <h2 id="confirm-title">Xác nhận thao tác</h2>
            <p id="confirm-message"></p>
            <div class="confirm-dialog__actions">
                <button type="button" class="btn confirm-dialog__cancel">Quay lại</button>
                <button type="button" class="btn btn-danger confirm-dialog__accept">Xác nhận xóa</button>
            </div>
        `;
        document.body.appendChild(confirmationDialog);

        confirmationDialog.querySelector(".confirm-dialog__cancel").addEventListener("click", function () {
            confirmationDialog.close("cancel");
        });
        confirmationDialog.querySelector(".confirm-dialog__accept").addEventListener("click", function () {
            confirmationDialog.close("confirm");
        });
        confirmationDialog.addEventListener("close", function () {
            if (confirmationResult) {
                confirmationResult(confirmationDialog.returnValue === "confirm");
                confirmationResult = null;
            }
        });
    }

    confirmationDialog.querySelector("#confirm-message").textContent = message;
    confirmationDialog.querySelector(".confirm-dialog__accept").textContent =
        /xóa/i.test(message) ? "Xác nhận xóa" : "Xác nhận";

    return new Promise(function (resolve) {
        confirmationResult = resolve;
        confirmationDialog.showModal();
    });
}

document.addEventListener("submit", function (event) {
    const form = event.target;
    if (!(form instanceof HTMLFormElement)) {
        return;
    }

    const submitter = event.submitter;
    if (approvedForm === form && approvedSubmitter === submitter) {
        approvedForm = null;
        approvedSubmitter = null;
        return;
    }

    const message = submitter && submitter.dataset.confirm
        ? submitter.dataset.confirm
        : form.dataset.confirm;
    if (!message) {
        return;
    }

    event.preventDefault();
    confirmAction(message).then(function (confirmed) {
        if (confirmed) {
            approvedForm = form;
            approvedSubmitter = submitter;
            if (submitter && submitter.form === form) {
                form.requestSubmit(submitter);
            } else {
                form.requestSubmit();
            }
        }
    });
});
