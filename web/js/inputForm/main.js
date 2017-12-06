
$(document).ready(start);

const FormState = {
    LOGIN: 0,
    REGISTRY: 1
};


function updateForm(state) {
    $(".registry").hide();
    $(".login").hide();
    switch (state)
    {
        case FormState.LOGIN:
            $(".login").show();
            break;
        case FormState.REGISTRY:
            $(".registry").show();
            break;
        default:
            throw new Error(`Unknown formState ${state}`);
    }
}


function start() {
    updateForm(FormState.LOGIN);

    const activeClass = "header-block_active";
    $("#login").click(function() {
        $(this).addClass(activeClass);
        const element = $("#registry");
        if (element.hasClass(activeClass))
        {
            element.removeClass(activeClass);
        }
        updateForm(FormState.LOGIN);
    });

    $("#registry").click(function() {
        $(this).addClass(activeClass);
        const element = $("#login");
        if (element.hasClass(activeClass))
        {
            element.removeClass(activeClass);
        }
        updateForm(FormState.REGISTRY);
    });
}

