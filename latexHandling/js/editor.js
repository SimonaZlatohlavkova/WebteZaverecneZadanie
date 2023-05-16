var mathFieldSpan = document.getElementById('math-field');
// var latexSpan = document.getElementById('latex');
var latexCode = "";

var MQ = MathQuill.getInterface(2); // for backcompat
var mathField = MQ.MathField(mathFieldSpan, {
    spaceBehavesLikeTab: true, // configurable
    handlers: {
        edit: function () { // useful event handlers
            // latexSpan.textContent = mathField.latex(); // simple API
            latexCode = mathField.latex();
        }
    }
});

function convertToMaxima(latexCode) {
    const math = mathjs.create();

    math.import({
        eta: math.unitStep
    });

    const expression = latexCode.replace(/\\eta/g, 'eta');
    const parsedExpression = math.parse(expression);
    const maximaCode = parsedExpression.toMaxima();

    return maximaCode;
}

const uploadImageButton = document.getElementById('submit-answer-button');
uploadImageButton.addEventListener('click', () => {

    if (latexCode == "") {
        console.log('Answer box is empty');
        return;
    }

    const maximaCode = convertToMaxima(latexCode);

    const formData = new FormData();
    formData.append('answer', maximaCode);

    axios.post('../php/answer-evaluation.php', formData)
        .then((response) => {
            console.log(response.data);

            // window.location.href = "../php/studentQuestions.php";
        })
        .catch((error) => console.log(error));
});


