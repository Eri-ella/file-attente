import '../css/client.css';


// acceuil
function changeTime() {
    let hour = document.getElementById("hour");
    let minute = document.getElementById("minute");

    function increase(initialValue, maxValue, block) {
        let currentValue = parseInt(initialValue.innerHTML);

        if(currentValue < maxValue && currentValue != parseInt(block)) {
            initialValue.innerHTML = currentValue + 1;
        } else {
            initialValue.innerHTML = block;
        }
    }

    if (minute) {
        setInterval ( () => {
            increase(minute, 59, "00")
        }, 134);
    }
    if (hour) {
        setInterval ( () => {
            increase(hour, 7, "7")
        }, 1000);    
    }
    

}

function slider () {
    let buttonLeft = document.getElementById("buttonLeft");
    let buttonRight = document.getElementById("buttonRight");
    let slidedContainer = document.getElementById("slidedContainer");

    if (!slidedContainer) return;

    const scrollAmount = 320;

    function goBack(){
        slidedContainer.scrollTo({ 
            left: slidedContainer.scrollLeft - scrollAmount, 
            behavior: 'smooth' 
        });
    }
    
    function goFor(){
        slidedContainer.scrollTo({ 
            left: slidedContainer.scrollLeft + scrollAmount, 
            behavior: 'smooth' 
        });
    }

    if (buttonLeft) buttonLeft.addEventListener("click", goBack);
    if (buttonRight) buttonRight.addEventListener("click", goFor);
}

function appearOnScroll () {
    var options = {
      root: null,
      rootMargin: "0px",
      threshold: 0.1,
    }
    var callback = function(entries, observer){
      entries.forEach(entry => {
        if (entry.isIntersecting){
          console.log(entry.target);
          entry.target.classList.add('show');
        } else {
          entry.target.classList.remove('show');
        }
      })
    } 

    var observer = new IntersectionObserver(callback, options)
    var targets = document.querySelectorAll('.card');  
    targets.forEach(target =>{
    observer.observe(target)
    })

    var targets2 = document.querySelectorAll('.card2');  
    targets2.forEach(target =>{
    observer.observe(target)
    }) 
}

// ===== STATS ODOMETER =====
function initStatsOdometer() {
    const statsSection = document.getElementById('statsSection');
    if (!statsSection) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Attendre l'entrée des cartes (animation .card.show)
                setTimeout(() => {
                    const cards = entry.target.querySelectorAll('.stat-card');
                    cards.forEach((card, index) => {
                        setTimeout(() => {
                            card.classList.add('odometer-active');
                            animateOdometer(card);
                        }, index * 250); // Décalage cascade entre les 4 cartes
                    });
                }, 400);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.25 });

    observer.observe(statsSection);
}

function animateOdometer(card) {
    const display = card.querySelector('.odometer-display');
    const value = parseInt(card.dataset.value) || 0;
    const suffix = card.dataset.suffix || '';
    const digits = String(value).split('');
    
    display.innerHTML = '';

    digits.forEach((digit, i) => {
        const digitContainer = document.createElement('div');
        digitContainer.className = 'odometer-digit';
        
        const strip = document.createElement('div');
        strip.className = 'odometer-strip';
        
        // Colonne de chiffres 0-9 empilés
        for (let n = 0; n <= 9; n++) {
            const span = document.createElement('span');
            span.textContent = n;
            strip.appendChild(span);
        }
        
        digitContainer.appendChild(strip);
        display.appendChild(digitContainer);

        // Déclenchement avec délai progressif (effet cascade gauche → droite)
        setTimeout(() => {
            strip.style.transform = `translateY(-${parseInt(digit) * 10}%)`;
        }, 150 + (i * 120));
    });

    // Suffixe (min, %)
    if (suffix) {
        const suffixSpan = document.createElement('span');
        suffixSpan.className = 'odometer-suffix';
        suffixSpan.textContent = suffix;
        display.appendChild(suffixSpan);
    }
}

// ===== TOP SERVICES ODOMETER =====
function initTopServicesOdometer() {
    const section = document.getElementById('topServicesSection');
    if (!section) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    // Odomètres de la carte centrale (cascade)
                    const odometers = section.querySelectorAll('.odometer-display-sm');
                    odometers.forEach((od, i) => {
                        setTimeout(() => {
                            animateOdometerSmall(od);
                        }, i * 250);
                    });
                    
                    // Compteurs latéraux
                    const sideCounters = section.querySelectorAll('.side-counter');
                    sideCounters.forEach((sc, i) => {
                        setTimeout(() => {
                            animateSideCounter(sc);
                        }, 800 + i * 200);
                    });
                }, 400);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    observer.observe(section);
}

function animateOdometerSmall(element) {
    const value = parseInt(element.dataset.value) || 0;
    const suffix = element.dataset.suffix || '';
    const digits = String(value).split('');
    
    element.innerHTML = '';
    element.classList.add('odometer-active');

    digits.forEach((digit, i) => {
        const digitContainer = document.createElement('div');
        digitContainer.className = 'odometer-digit-sm';
        
        const strip = document.createElement('div');
        strip.className = 'odometer-strip-sm';
        
        for (let n = 0; n <= 9; n++) {
            const span = document.createElement('span');
            span.textContent = n;
            strip.appendChild(span);
        }
        
        digitContainer.appendChild(strip);
        element.appendChild(digitContainer);

        setTimeout(() => {
            strip.style.transform = `translateY(-${parseInt(digit) * 10}%)`;
        }, 150 + (i * 120));
    });

    if (suffix) {
        const suffixSpan = document.createElement('span');
        suffixSpan.className = 'odometer-suffix-sm';
        suffixSpan.textContent = suffix;
        element.appendChild(suffixSpan);
    }
}

function animateSideCounter(element) {
    const finalValue = parseInt(element.dataset.value) || 0;
    const textNode = document.createTextNode('');
    element.innerHTML = '';
    element.appendChild(textNode);
    
    let current = 0;
    const duration = 1200;
    const stepTime = Math.max(10, Math.floor(duration / finalValue));
    
    const timer = setInterval(() => {
        current++;
        textNode.nodeValue = current + ' réservations';
        if (current >= finalValue) {
            clearInterval(timer);
        }
    }, stepTime);
}

document.addEventListener('DOMContentLoaded', function() {
    changeTime();
    slider();
    appearOnScroll();
    initStatsOdometer();
    initTopServicesOdometer();
});

// service

function changeService (page) {
    
    let thematique = document.getElementById('thematique');
    let profil = document.getElementById('profil');
    let critere = document.getElementById('critere');

    let serviceTab = [thematique, profil, critere];

    serviceTab.forEach(element => {
        if(element) {
            if(element.id === page){
                element.classList.add('flex');
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
                element.classList.remove('flex');
            }    
        }
        
    });

}

function newServ () {

    let service_thematique = document.getElementById("service_thematique");
    let service_profil = document.getElementById("service_profil");
    let service_critere = document.getElementById("service_critere");


    if (service_thematique) {
        service_thematique.addEventListener("click",() => {
            changeService('thematique');
        });
    }

    if (service_profil) {
        service_profil.addEventListener("click",() => {
            changeService('profil');            
        });
    }

    if (service_critere) {
        service_critere.addEventListener("click",() => {
            changeService('critere');
        });
    }
}


// profil

function changeProfil (page) {
    
    let profil_historique = document.getElementById('profil_historique');
    let profil_infos = document.getElementById('profil_infos');

    let profilTab = [profil_infos, profil_historique];

    profilTab.forEach(element => {
        if(element) {
            if(element.id === page){
                element.classList.add('flex');
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
                element.classList.remove('flex');
            }    
        }
    });
}

function initProfil () {

    let info_click = document.getElementById("info_click");
    let histo_click = document.getElementById("histo_click");

    if (info_click) {
        info_click.addEventListener("click",() => {
            changeProfil('profil_infos');
        });
    }

    if (histo_click) {
        histo_click.addEventListener("click",() => {
            changeProfil('profil_historique');
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    newServ();
    initProfil();
});

// profil connexion 
function togglePassword() {
    document.querySelectorAll('.password-icon').forEach(wrap => {
        const input = wrap.parentElement?.querySelector('input[type="password"], input[type="text"]');
        const eyeOpen = wrap.querySelector('.eye-open, svg.feather-eye');
        const eyeClosed = wrap.querySelector('.eye-closed, svg.feather-eye-off');
        
        if (!input || !eyeOpen) return;
        
        wrap.addEventListener('click', () => {
            const isPwd = input.type === 'password';
            input.type = isPwd ? 'text' : 'password';
            eyeOpen.classList.toggle('hidden', isPwd);
            if (eyeClosed) eyeClosed.classList.toggle('hidden', !isPwd);
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    togglePassword();
});