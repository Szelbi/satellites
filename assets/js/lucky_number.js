import $ from 'jquery';

let rotationAngle = 180;

$(document).ready(function() {
    $('#btn-spinner').on('click', function() {
        rotateIcon();
        getLuckyNumber();
    });
});

function getLuckyNumber() {
    fetch('/lucky/number/get')
        .then(response => response.json())
        .then(data => {
            $('#lucky-number').text(data.number);
        });
}

function rotateIcon() {
    rotationAngle += 120;

    let spinner = $('#spinner-icon');
    spinner.addClass('clicked');
    spinner.css('transform', 'rotate(' + rotationAngle + 'deg)');

}
