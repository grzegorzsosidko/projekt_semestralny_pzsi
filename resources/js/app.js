import './bootstrap';

// Alpine.js (jeśli jest używany)
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// import 'cropperjs/dist/cropper.css';
// import Cropper from 'cropperjs';
// window.MyAvatarCropper = Cropper;

import lightGallery from 'lightgallery';
import 'lightgallery/css/lightgallery.css';
import 'lightgallery/css/lg-thumbnail.css';
import 'lightgallery/css/lg-zoom.css';
import lgThumbnail from 'lightgallery/plugins/thumbnail';
import lgZoom from 'lightgallery/plugins/zoom';

window.lightGallery = lightGallery;
window.lgThumbnail = lgThumbnail;
window.lgZoom = lgZoom;

import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
window.Swal = Swal;
