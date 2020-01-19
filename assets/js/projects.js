const $ = require('jquery');

let _s = {
    technology_button: '.technology_button',
    all_technologies_button: '.all_technologies_button',
    projects: '.list_posts',
};

let _c = {
    selected: 'selected',
    none: 'd-none',
    flex: 'd-flex',
};

let selected_technologies = [];

$(_s.technology_button).each(function() {
    $(this).on('click', function() {
        technology_button_click($(this));
    });
});

$(_s.all_technologies_button).on('click', function() {
    all_technologies_button_click($(this));
    show_all_projects();
});

/*
 FUNCTIONS
*/

function technology_button_click(elt) {
    let id = elt.attr('id');
    let selected_index = selected_technologies.indexOf(id);

    if (elt.hasClass(_c.selected)) {
        elt.removeClass(_c.selected);

        if (selected_index !== -1) {
            selected_technologies.splice(selected_index, 1);
        }
    } else {
        elt.addClass(_c.selected);

        if ($(_s.all_technologies_button).hasClass(_c.selected)) {
            $(_s.all_technologies_button).removeClass(_c.selected);
        }

        if (selected_index === -1) {
            selected_technologies.push(id);
        }
    }

    filter_projects();
}

function all_technologies_button_click(elt) {
    if (!elt.hasClass(_c.selected)) {
        $(_s.technology_button).each(function() {
            if ($(this).hasClass(_c.selected)) {
                $(this).removeClass(_c.selected);
            }
        });

        selected_technologies = [];

        elt.addClass(_c.selected);
    }
}

function filter_projects() {
    $(_s.projects).each(function() {
        if ($(this).hasClass(_c.flex)) {
            $(this).removeClass(_c.flex);
        }
        if (!$(this).hasClass(_c.none)) {
            $(this).addClass(_c.none);
        }
    });

    $(_s.projects).each(function() {
        let project_technologies = $(this).children().attr('data-technos').split(',');
        let project = $(this);

        project_technologies.forEach(function(technology) {
            if (selected_technologies.indexOf(technology) !== -1) {
                project.removeClass(_c.none);
                project.addClass(_c.flex);
            }
        })
    });
}

function show_all_projects() {
    $(_s.projects).each(function() {
        if ($(this).hasClass(_c.none)) {
            $(this).removeClass(_c.none);
            $(this).addClass(_c.flex);
        }
    });
}
