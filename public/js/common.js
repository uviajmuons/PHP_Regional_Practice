const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const $header = $('header');
this.onscroll = () => {
  if (this.scrollY > 70) $header.classList.add('header-shadow');
  else $header.classList.remove('header-shadow');
}