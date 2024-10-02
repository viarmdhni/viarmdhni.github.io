function showPopup(produk) {
    popupTitle.textContent = produk;
    
    const detailproduk = {
        Serum: 'Produk ini adalah serum anti-aging yang kaya akan peptida dan asam hialuronat, membantu mengurangi tanda-tanda penuaan dan menjaga kulit tetap lembap.',
        Moisturizer: 'Produk ini adalah krim pelembap dengan kandungan vitamin E dan aloe vera yang melembapkan kulit secara mendalam, membuatnya terasa halus dan lembut.',
        Toner: 'Produk ini adalah toner lembut dengan ekstrak chamomile, sangat cocok untuk menenangkan kulit sensitif.',
        Sunscreen:'Produk ini adalah sunscreen yang melindungi kulit dari sinar UV, menjaga kulit tetap sehat dan terhidrasi.',
        FacialWash: 'Produk ini adalah pembersih wajah lembut yang efektif mengangkat kotoran, cocok untuk penggunaan sehari-hari.',
    };
    popupContent.textContent = detailproduk[produk];
    popup.style.display = 'block';
    overlay.style.display = 'block';
}

function closePopup() {
    const popup = document.getElementById('popup');
    const overlay = document.getElementById('overlay');

    popup.style.display = 'none';
    overlay.style.display = 'none';
}