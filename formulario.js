document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    fetch(this.action, {
        method: this.method,
        body: new FormData(this)
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert(data.message);
            if(data.redirect) {
                // Redirigir después del delay
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, data.redirectDelay || 3000);
            }
        } else {
            alert(data.message || 'Error al enviar el formulario');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la solicitud');
    });
});

$('form').submit(function(e) {
    e.preventDefault();
    
    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {
            if(data.success && data.redirect) {
                alert(data.message);
                setTimeout(function() {
                    window.location.href = data.redirect;
                }, data.redirectDelay || 3000);
            }
        }
    });
});