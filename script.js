document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Ride booked successfully!');

    // Insert booking data into the Ride History table
    const tbody = document.querySelector('#rideHistory tbody');
    const row = document.createElement('tr');
    
    const pickup = document.getElementById('pickup').value;
    const destination = document.getElementById('destination').value;
    const date = document.getElementById('date').value;

    row.innerHTML = `<td>${pickup}</td><td>${destination}</td><td>${date}</td><td>Confirmed</td>`;
    tbody.appendChild(row);

    this.reset();
});

document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Payment processed successfully!');
    this.reset();
});
