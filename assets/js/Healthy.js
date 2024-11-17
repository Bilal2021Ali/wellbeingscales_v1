const RunStepsValidator = () => {
    let isValid = 0;
    let Valid = false;
    $(".step .actions-container").each(function () {
        if ($(this).children('.action-btn.active').length < 1) {
            console.log("huh?");
            $(".step.active .steps .submit").removeClass('clickable');
            return false;
        }
        isValid++;
    });
    if (isValid == $(".step .actions-container").length) {
        $(".step .steps .submit").addClass('clickable');
        Valid = true;
    }
    return Valid;
};

const getResults = () => {
    const values = {answers: [], priorities: []};
    $(".step .actions-container").each(function () {
        let category = $(this).data("category");
        let question = $(this).data("question");
        $(this).children('.action-btn.active').each(function () {
            if ($(this).hasClass('choice-btn')) {
                values.answers.push({
                    category, question,
                    id: $(this).data("key"),
                    value: $(this).data("value")
                });
            } else {
                values.priorities.push({
                    category, question, id: $(this).data("key"),
                    value: $(this).data("value")
                });
            }
        });
    });

    return values;
};

// mark the answer
$("body").on('click', '.action-btn', function () {
    $(this).parents(".d-flex").children().removeClass("active");
    $(this).addClass('active');
    RunStepsValidator();
});

// back one step or forward one
$("body").on('click', '.steps .back,.steps .next', function () {
    if (!$(this).hasClass("clickable")) {
        return;
    }
    $(".step").removeClass('active');
    $(".step.step-" + $(this).data("to")).addClass('active');
});

$("body").on('click', '.steps .submit', function () {
    if (!RunStepsValidator()) {
        return;
    }
    const data = getResults();
    console.log(data);
    $.ajax({
        type: 'POST',
        url: base_url + 'index.php/Healthy/save',
        data,
        success: function (response) {
            if (response.status === 'ok') {
                $(".steps .submit").removeClass('clickable').attr('disabled', '').html(generatingTheResults);
                location.href = base_url + 'index.php/Healthy/Results/' + response.key + '/' + activeLanguage;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry We had an Error',
                    text: response.message
                });
            }
        },
        ajaxError: function () {
            Swal.fire({
                icon: 'error',
                title: 'Sorry',
                text: 'We had an unexpected Error'
            });
        }
    });
});