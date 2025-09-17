// Ensure skip-to-content focuses the main region
document.addEventListener('DOMContentLoaded', () => {
  const skip = document.querySelector('a[href="#main"]');
  const main = document.getElementById('main');
  if(skip && main){
    skip.addEventListener('click', () => { main.setAttribute('tabindex','-1'); main.focus(); });
  }
});

