function messger({title = '', mess = '', type = 'info', duration = 2000}) {
    const main = document.getElementById('messger');
    if (main) {
        const messger = document.createElement('div');  
        messger.onclick = function (e) {
            if (e.target.closest('.messger__close')) {
                messger.remove();
            }
        }
        const icons = {
            success: 'fas fa-check-circle',
            info: 'fas fa-info-circle',
            warning: 'fas fa-exclamation-circle',
            error: 'fas fa-exclamation-circle',
        };
        const icon = icons[type];
        const delay = (duration / 1000).toFixed(2);

        messger.classList.add('messger', `messger--${type}`);
        messger.style.animation = `slideInLeft ease 1s, fadeOut linear 1s ${delay}s forwards`;

        messger.innerHTML = `
                <div class="messger__icon">
                        <i class="${icon}"></i>
                    </div>
                    <div class="messger_content">
                        <h3 class="messger__title">${title}</h3>
                        <p class="messger__msg">${mess}</p>
                    </div>
                    <div class="messger__close">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
        `;
        main.appendChild(messger);
        setTimeout(() => {
            messger.remove();
        }, duration + 1000);
    }else{
        console.log('Không tìm thấy thẻ thông báo!');
    }
}