const pages = document.querySelectorAll(".page")
const header = document.querySelector("header")
let pageActive=1
window.onload = () => {
    document.querySelector(".page").style.display = "initial"
    pages.forEach((page, index) => {
        let element = document.createElement("div")
        element.classList.add("page-num")
        element.id = "num" + (index + 1)
        if(pageActive === index + 1) {
            element.classList.add("active")
        }
        element.innerHTML = index + 1
        header.appendChild(element)
    })
    let boutons = document.querySelectorAll("button[type=button]")
    for (let bouton of boutons){
        bouton.addEventListener("click", pageSuivante)

    }
}

function pageSuivante(){


    for(let page of pages){
        page.style.display = "none"
    }
    this.parentElement.nextElementSibling.style.display = "initial"
    document.querySelector(".active").classList.remove("active")
    pageActive++
    document.querySelector("#num"+pageActive).classList.add("active")
}
