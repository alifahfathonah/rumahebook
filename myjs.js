// -----------------------------------
//      set height of section one
// -----------------------------------
let windowHeight = window.innerHeight;
document.querySelector('section.sec-one') ? document.querySelector('section.sec-one').style.minHeight = windowHeight+'px' : '';
document.querySelector('section.sec-login') ? document.querySelector('section.sec-login').style.minHeight = windowHeight+'px' : '';
document.querySelector('section.sec-one .wrapEdit') ? document.querySelector('section.sec-one .wrapEdit').style.minHeight = (windowHeight/2)+'px' : '';
document.querySelector('section.sec-one .container-lemari') ? document.querySelector('section.sec-one .container-lemari').style.minHeight = (windowHeight/1.7)+'px' : '';
document.querySelector('#div-tabel-admin') ? document.querySelector('#div-tabel-admin').style.maxHeight = (windowHeight/1.8)+'px' : '';
document.querySelector('#div-tabel-ebook') ? document.querySelector('#div-tabel-ebook').style.maxHeight = (windowHeight/1.8)+'px' : '';

// -----------------------------------
//      Js For index main page
// -----------------------------------

let SearchIndex = document.querySelector('#formSearchIndex');
if(SearchIndex){
    let Lemari = document.querySelector('#lemariIndex');
    SearchIndex.addEventListener('keyup', function () {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                Lemari.innerHTML = xhr.responseText;
            }
        }
        xhr.open('GET', 'ajax/ebookSearch.php?key=' + SearchIndex.value, true);
        xhr.send();
    });
}

// -----------------------------------
//      Js For Kategori page
// -----------------------------------

let SearchKategori = document.querySelector('#formSearchKateGori');
if(SearchKategori){
    let lemariKategori = document.querySelector('#lemariKategori');
    let kategori = document.querySelector('.KateKale h1 span').textContent;
    SearchKategori.addEventListener('keyup', function () {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                lemariKategori.innerHTML = xhr.responseText;
            }
        }
        xhr.open('GET', '../ajax/kategoriSearch.php?key=' + SearchKategori.value + '&kategori=' + kategori, true);
        xhr.send();
    });
}

// -----------------------------------
//      Js For CRUD page
// -----------------------------------
let searchAdmin = document.getElementById('SearchAdmin');
if(searchAdmin){
    let divTabelAdmin = document.getElementById('div-tabel-admin');
    searchAdmin.addEventListener('keyup', function () {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                divTabelAdmin.innerHTML = xhr.responseText;
            }
        }
        xhr.open('GET', '../ajax/tabeladmin.php?key=' + searchAdmin.value, true);
        xhr.send();
    })
}
let searchEbook = document.getElementById('SearchEbook');
if(searchEbook){
    let divTabelEbook = document.getElementById('div-tabel-ebook');
    searchEbook.addEventListener('keyup', function () {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                divTabelEbook.innerHTML = xhr.responseText;
            }
        }
        xhr.open('GET', '../ajax/tabelebook.php?key=' + searchEbook.value, true);
        xhr.send();
    })
}

// -----------------------------------
//      Js For edit page
// -----------------------------------
let peraturan = document.querySelector('.peraturan');
if(peraturan){
    let close = document.querySelector('.peraturan .closee');
    setTimeout(function () {
        peraturan.classList.add('rise');
    }, 1000);
    close.addEventListener('click', function () {
        peraturan.classList.remove('rise');
    })
}