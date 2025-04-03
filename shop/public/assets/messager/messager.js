function messager({title = '', mess = '', type = 'info', duration = 2000}) {
    const main = document.getElementById('messager');
    if (main) {
        main.innerHTML = '';
        const messager = document.createElement('div');  
        messager.onclick = function (e) {
            if (e.target.closest('.messager__close')) {
                messager.remove();
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

        messager.classList.add('messager', `messager--${type}`);
        messager.style.animation = `slideInLeft ease 1s, fadeOut linear 1s ${delay}s forwards`;

        messager.innerHTML = `
                <div class="messager__icon">
                        <i class="${icon}"></i>
                    </div>
                    <div class="messager_content">
                        <h3 class="messager__title">${title}</h3>
                        <p class="messager__msg">${mess}</p>
                    </div>
                    <div class="messager__close">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
        `;
        main.appendChild(messager);
        setTimeout(() => {
            messager.remove();
        }, duration + 1000);
    }else{
        console.log('Không tìm thấy thẻ thông báo!');
    }
}