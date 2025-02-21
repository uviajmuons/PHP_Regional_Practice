const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const $header = $('header');
this.onscroll = () => {
  if (this.scrollY > 70) $header.classList.add('header-shadow');
  else $header.classList.remove('header-shadow');
}

const imgFileLoader = (e, selector, objfit = false) => {
  const file = e.target.files[0];
  const reader = new FileReader();
  reader.onload = ({ target }) => { $(selector).innerHTML = `<img src="${target.result}" alt="${file.name}" style="width: 100%; height: 100%; ${ objfit === true ? 'object-fit: cover;' : '' }">` ;};
  reader.readAsDataURL(file);
}