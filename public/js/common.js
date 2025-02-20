const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const $header = $('header');
this.onscroll = () => {
  if (this.scrollY > 70) $header.classList.add('header-shadow');
  else $header.classList.remove('header-shadow');
}

const imgFileLoader = (e) => {
  const file = e.target.files[0];
  const reader = new FileReader();
  reader.onload = ({ target }) => { $('.post-insert-img').innerHTML = ` <img src="${target.result}" alt="${file.name}" style="width: 100%; height: 100%;">` ;};
  reader.readAsDataURL(file);
}