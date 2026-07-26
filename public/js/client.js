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

    setInterval ( () => {
        increase(minute, 59, "00")
    }, 134);
    setInterval ( () => {
        increase(hour, 7, "7")
    }, 1000);

}

function slider () {
    let buttonLeft = document.getElementById("buttonLeft");
    let buttonRight = document.getElementById("buttonRight");
    let slidedContainer = document.getElementById("slidedContainer");

    function goBack(){
        slidedContainer.scrollLeft -= 320;
    }
    function goFor(){
        // const widthSlider = (width / 4);
        slidedContainer.scrollLeft += 320;
    }

    buttonLeft.addEventListener("click", () => {goBack()});
    buttonRight.addEventListener("click", () => {goFor()});
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

document.addEventListener('DOMContentLoaded', function() {
    changeTime();
    slider();
    appearOnScroll();
});

// service

function changeSrc(src1, src2){
    let frame_list = document.getElementById("frame_list");
    let frame_grid = document.getElementById("frame_grid");

    if (frame_list && frame_grid) {
        frame_list.src = src1;
        frame_grid.src = src2;
    }
}

function initServices () {
    let service_thematique = document.getElementById("service_thematique");
    let service_profil = document.getElementById("service_profil");
    let service_critere = document.getElementById("service_critere");

    if (service_thematique) {
        service_thematique.addEventListener("click",() => {
            changeSrc("serviceThematiqueList.html", "serviceThematiqueGrid.html");
        });
    }

    if (service_profil) {
        service_profil.addEventListener("click",() => {
            changeSrc("serviceProfilList.html", "serviceProfilGrid.html");
            
        });
    }

    if (service_critere) {
        service_critere.addEventListener("click",() => {
            changeSrc("serviceCritereList.html", "serviceCritereGrid.html");
        });
    }

}


// profil
function initProfile() {
    let info_click = document.getElementById("info_click");
    let histo_click = document.getElementById("histo_click");

    info_click.addEventListener("click", () => {document.getElementById("frame_profil").src="profilInfos.html"});
    histo_click.addEventListener("click", () => {document.getElementById("frame_profil").src="historique.html"});
}

document.addEventListener('DOMContentLoaded', function() {
    initServices();
    initProfile();
});

