MathJax.startup.promise.then(() => {
    const math = document.getElementById('question').innerHTML;
    mathjax.typesetPromise(math);
});