import tt from '@tomtom-international/web-sdk-maps';

// Inizializzo coordinate

    let cordinate = [longitude, latitude];
    const map = tt.map({
        key: 'ZKEljqh55cAJVmD8GpeG3iI4JmV5HEDm',
        container: 'map',
        center: cordinate,
        zoom: 15
    });

    //Add custom marker to map

    let marker = new tt.Marker().setLngLat(cordinate).addTo(map);

    let popupOffsets = {
        top: [0, 0],
        bottom: [0, -45],
        'bottom-right': [0, -70],
        'bottom-left': [0, -70],
        left: [25, -35],
        right: [-25, -35]
    }

    // Show pop-up 
    let popup = new tt.Popup({
        offset: popupOffsets
    }).setHTML(title + '<br>' + address);
    marker.setPopup(popup).togglePopup();
