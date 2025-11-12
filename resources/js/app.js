import "./bootstrap";
import {
    Livewire,
    Alpine,
} from "../../vendor/livewire/livewire/dist/livewire.esm";
import Swiper from "swiper";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
import Swal from "sweetalert2";

// Register Swiper modules
Swiper.use([Navigation, Pagination, Autoplay]);

// Initialize Swiper
document.addEventListener("DOMContentLoaded", () => {
    new Swiper(".video-carousel", {
        modules: [Navigation, Pagination, Autoplay],
        loop: true,
        autoplay: {
            delay: 5000,
        },
        pagination: {
            el: ".swiper-pagination",
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        slidesPerView: 1,
        spaceBetween: 10,
    });
});

// SweetAlert global config
window.Swal = Swal;

// Livewire event listeners
Livewire.on("notify", (data) => {
    Swal.fire({
        icon: data.type,
        title: data.title || "Notifikasi",
        text: data.message,
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
    });
});

Livewire.start();
