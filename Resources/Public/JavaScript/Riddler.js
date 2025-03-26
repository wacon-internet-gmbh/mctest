class Riddler
{
  constructor() {
    this.initQuizzes();
  }

  initQuizzes() {
    let cObj = this;
    document.querySelectorAll('.tx-mctest-ajax').forEach((element) => {
      // Avoid multiple init on one quiz
      if (element.hasAttribute('data-quizinit') && element.getAttribute('data-quizinit') == 'true') {
        return;
      }

      element.setAttribute('data-quizinit', 'true');
      let form = element.querySelector('form');

      if (form) {
        const newQuiz = new Quiz(element.querySelector('form'), element.parentElement);
        cObj.observeContainer(element.parentElement);
      }
    });
  }

  observeContainer(container) {
    let cObj = this;
    this.observer = new MutationObserver((mutations) => {
      mutations.forEach((mutation) => {
        if (mutation.type == "childList" && mutation.addedNodes.length > 0) {
          cObj.initQuizzes();
        }
      });
    });

    this.observer.observe(container, {
      subtree: false,
      childList: true,
    });
  }
}

document.addEventListener('DOMContentLoaded', (event) => {
  const riddler = new Riddler();
});
