function get_post_wp() {
    const url = "https://sysmocompany.com/page/wp-json/wp/v2/posts?_embed";
    fetch(url).then(data => {
        return data.json()
    }).then(res => {
        render_post(res)
    });
}
function render_post(data) {
    const sectionNews = document.getElementById('section_news');
    if(data === null || data.length === 0){
        sectionNews.classList.add('hidden');
        return false;
    }
    //return console.log(data[0]['_embedded']["wp:featuredmedia"][0]['source_url']);
    const slider = sectionNews.querySelector('#slider_news .slider__wrapper');
    let item = null;
    let sticky = null;
    data.forEach(d => {
        //console.log(d);
        if(sticky === null && d.sticky === true){
            sticky = d;
        }else{
            let img_src = "https://sysmocompany.com/page/wp-content/uploads/2022/04/placeholder.png";
            if(d['_embedded']['wp:featuredmedia']){
                img_src = d['_embedded']['wp:featuredmedia'][0]['source_url'];
            }
            item = document.createElement('div');
            item.className = 'slider__item';
            if(d.sticky === true){
                item.innerHTML = `<div class="content">${d.content.rendered}</div>
                               <h5 class="title">${d.title.rendered}</h5>`;
            }else{
                item.innerHTML = `<a href="${d.link}"><img src="${img_src}" alt="" class="img_new">
                            <h5 class="title_new">${d.title.rendered}</h5></a>`;
            }
            slider.appendChild(item);
        }
    });

    if(sticky !== null){
        const mainNew = sectionNews.querySelector('.main_new');
        mainNew.innerHTML = `<div class="content">${sticky.content.rendered}</div>
                               <h5 class="title">${sticky.title.rendered}</h5>`;
    }
    multiItemSlider('.slider');
}
(() => {
    get_post_wp();
})();