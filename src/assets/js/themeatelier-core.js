
  document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const discountCode = params.get('discount');
    console.log(params);
      if (discountCode == 'freetopro') {
      document.querySelectorAll('.ta_regular_price').forEach(function (el) {
        const text = el.textContent.trim();
        const originalPrice = parseFloat(text);
        if (!isNaN(originalPrice)) {
          const discountedPrice = (originalPrice * 0.85).toFixed(2);
          el.textContent = `$${discountedPrice}`;
        }
      });
    }

    // 2. If discount param exists, append it to all buy now links silently
    if (discountCode) {
      document.querySelectorAll('.ta_price_wrapper').forEach(function (link) {

        if (link.href) {
          try {
            const url = new URL(link.href, window.location.origin);
            url.searchParams.set('discount', discountCode);
            link.href = url.toString();
          } catch (e) {
            // Silently ignore malformed URLs
          }
        }
      });
    }
  });
