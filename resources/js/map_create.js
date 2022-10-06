import tt from '@tomtom-international/web-sdk-maps';
import SearchBox from '@tomtom-international/web-sdk-plugin-searchbox';
import {
    services
} from '@tomtom-international/web-sdk-services';

let cordinate = [12.49427, 41.89056];

let map = tt.map({
    key: 'wwBjO0iyrGBDWYAR81J5EY7D4Y0HJGQj',
    container: 'map',
    center: cordinate,
    zoom: 5
});

const options = {
    idleTimePress: 100,
    minNumberOfCharacters: 0,
    searchOptions: {
        key: 'wwBjO0iyrGBDWYAR81J5EY7D4Y0HJGQj',
        language: 'it-IT',
        extendedPostalCodesFor: 'Str',
        limit: 1,
        countrySet: 'IT'
    },
    autocompleteOptions: {
        key: 'wwBjO0iyrGBDWYAR81J5EY7D4Y0HJGQj',
        language: 'it-IT',
    },
    noResultsMessage: 'No results found.',
    labels: {
        placeholder: 'Via indipendenza 13, Milano 20090'
    }
};

function SearchMarker(poiData, options) {
    this.poiData = poiData;
    this.options = options || {};
    this.marker = new tt.Marker({
        element: this.createMarker(),
        anchor: 'bottom'
    });
    let lon = this.poiData.position.lng || this.poiData.position.lon;
    this.marker.setLngLat([
        lon,
        this.poiData.position.lat
    ]);
}

SearchMarker.prototype.addTo = function (map) {
    this.marker.addTo(map);
    this._map = map;
    return this;
};

SearchMarker.prototype.createMarker = function () {
    let elem = document.createElement('div');
    elem.className = 'tt-icon-marker-black tt-search-marker';
    if (this.options.markerClassName) {
        elem.className += ' ' + this.options.markerClassName;
    }
    let innerElem = document.createElement('div');
    innerElem.setAttribute('style', 'background: white; width: 0.5rem; height: 0.5rem; border-radius: 50%; border: 3px solid red;');

    elem.appendChild(innerElem);
    return elem;
};

SearchMarker.prototype.remove = function () {
    this.marker.remove();
    this._map = null;
};

function SearchMarkersManager(map, options) {
    this.map = map;
    this._options = options || {};
    this._poiList = undefined;
    this.markers = {};
}

SearchMarkersManager.prototype.draw = function (poiList) {
    this._poiList = poiList;
    this.clear();
    this._poiList.forEach(function (poi) {
        let markerId = poi.id;
        let poiOpts = {
            name: poi.poi ? poi.poi.name : undefined,
            address: poi.address ? poi.address.freeformAddress : '',
            distance: poi.dist,
            classification: poi.poi ? poi.poi.classifications[0].code : undefined,
            position: poi.position,
            entryPoints: poi.entryPoints
        };
        let marker = new SearchMarker(poiOpts, this._options);
        marker.addTo(this.map);
        this.markers[markerId] = marker;
    }, this);
};

SearchMarkersManager.prototype.clear = function () {
    for (let markerId in this.markers) {
        let marker = this.markers[markerId];
        marker.remove();
    }
    this.markers = {};
    this._lastClickedMarker = null;
};

let ttSearchBox = new SearchBox(services, options);
//let marker = new tt.Marker().setLngLat(cordinate).addTo(map);
let searchMarkersManager = new SearchMarkersManager(map);
ttSearchBox.on('tomtom.searchbox.resultsfound', handleResultsFound);
ttSearchBox.on('tomtom.searchbox.resultselected', handleResultSelection);
ttSearchBox.on('tomtom.searchbox.resultfocused', handleResultSelection);
ttSearchBox.on('tomtom.searchbox.resultscleared', handleResultClearing);
map.addControl(ttSearchBox, 'top-left');

function handleResultsFound(event) {
    let results = event.data.results.fuzzySearch.results;

    if (results.length === 0) {
        searchMarkersManager.clear();
    }
    searchMarkersManager.draw(results);
    fitToViewport(results);

    if (results.length > 0) {
        let lat = results[0].position.lat;
        let lon = results[0].position.lng;
        let address = results[0].address.freeformAddress;
        document.getElementById('lat').value = lat;
        document.getElementById('lon').value = lon;
        document.getElementById('address').value = address;
    }
}

function handleResultSelection(event) {
    let result = event.data.result;
    if (result.type === 'category' || result.type === 'brand') {
        return;
    }
    searchMarkersManager.draw([result]);
    fitToViewport(result);
}

function fitToViewport(markerData) {
    if (!markerData || markerData instanceof Array && !markerData.length) {
        return;
    }
    let bounds = new tt.LngLatBounds();
    if (markerData instanceof Array) {
        markerData.forEach(function (marker) {
            bounds.extend(getBounds(marker));
        });
    } else {
        bounds.extend(getBounds(markerData));
    }
    map.fitBounds(bounds, { padding: 100, linear: true });
}

function getBounds(data) {
    let btmRight;
    let topLeft;
    if (data.viewport) {
        btmRight = [data.viewport.btmRightPoint.lng, data.viewport.btmRightPoint.lat];
        topLeft = [data.viewport.topLeftPoint.lng, data.viewport.topLeftPoint.lat];
    }
    return [btmRight, topLeft];
}

function handleResultClearing() {
    searchMarkersManager.clear();
}

