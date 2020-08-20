require('select2');

$('#giveout_member').select2({
    theme: 'bootstrap4'
});

$('#giveout_member').on('change.select2', function () {
    let memberId = $(this).val();
    const targetClass = $(this).data('target-class');

    let ammo = window.member_ammo[memberId];

    if (! ammo) {
        // Unknown person or default value (no person)
        document.getElementById('giveout-info').classList.add('d-none');
        document.querySelectorAll(`.${targetClass}-ammo`).forEach(input => input.setAttribute('value', 0));
        return;
    }

    for (const [caliberId, ammo] of Object.entries(ammo)) {
        document.getElementById('giveout-info').classList.remove('d-none');
        document.getElementById(`${targetClass}_quantity_${caliberId.toString()}`).setAttribute('value', ammo);
    }
});
