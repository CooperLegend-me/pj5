function submitOrder() {
    const formData = {
        house_type: document.getElementById('house-type').value,
        roof_type: document.getElementById('roof-type').value,
        foundation_type: document.getElementById('foundation-type').value,
        finishing_material: document.getElementById('finishing-material').value,
        windows_type: document.getElementById('windows-type').value,
        heating_type: document.getElementById('heating-type').value,
        sewage_type: document.getElementById('sewage-type').value,
        construction_time: document.getElementById('construction-time').value,
        additional_services: getSelectedServices(),
        total_cost: calculateTotalCost()
    };

    fetch('/orders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = data.redirect;
        } else {
            alert(data.message || 'Произошла ошибка при отправке заказа');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при отправке заказа');
    });
} 