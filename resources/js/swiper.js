
// core version + navigation, pagination modules:
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

  // configure Swiper to use modules
 Swiper.use([Navigation]);

window.addEventListener('load', function() {
    const swiper = new Swiper('.swiper', {
        // Optional parameters
        // direction: 'vertical',
        loop: false,

        freeMode: true,
        watchSlidesProgress: true,

        //  // If we need pagination
        // pagination: {
        // el: '.swiper-pagination',
        // },

        // Navigation arrows
        navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
        },

        // And if we need scrollbar
        scrollbar: {
        el: '.swiper-scrollbar',
        },
    });

});
