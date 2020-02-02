// https://bitbucket.org/reind33r/aflc3/src/master/resources/assets/js/forms.js

function form_collection_add(container_id) {
    var container = document.getElementById(container_id);
    var next_index = parseInt(container.getAttribute('data-nextIndex'));

    var prototype = container.getAttribute('data-prototype');
    var dom_template = document.createElement('template');
    dom_template.innerHTML = prototype.replace(/__INDEX__/g, next_index);
    var new_item = dom_template.content.firstChild;
    container.appendChild(new_item);

    container.setAttribute('data-nextIndex', next_index + 1);

    new_item.querySelectorAll('button[data-action]').forEach(function(button) {
        button.addEventListener('click', button_onclick_listener);
    });
}

var button_onclick_listener = function(e) {
    e.preventDefault();

    var action = this.getAttribute('data-action');

    if(action == 'formCollectionAdd') {
        form_collection_add(this.getAttribute('data-formCollection'));
    } else if(action == 'deleteCollectionItem') {
        this.closest('[data-collectionItem]').remove();
    }

    return false;
};

document.querySelectorAll('button[data-action]').forEach(function(button) {
    button.addEventListener('click', button_onclick_listener);
});