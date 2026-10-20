/* global Alpine */
document.addEventListener('alpine:init', () => {
  Alpine.data('imageMosaic', () => ({
    lightboxOpen: false,
    activeImage: { src: '', alt: '' },

    openLightbox(src, alt) {
      this.activeImage = { src, alt };
      this.lightboxOpen = true;
      this.$nextTick(() => {
        const closeBtn = this.$el.querySelector('.canvas-image-mosaic__lightbox-close');
        if (closeBtn) {
          closeBtn.focus();
        }
      });
    },

    closeLightbox() {
      this.lightboxOpen = false;
      this.activeImage = { src: '', alt: '' };
    },

    handleKeydown(e) {
      if (e.key === 'Escape' && this.lightboxOpen) {
        this.closeLightbox();
      }
    },
  }));
});
