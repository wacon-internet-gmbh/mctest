class Riddler
{
  constructor() {
    this.initQuizzes();
  }

  initQuizzes() {
    let cObj = this;
    document.querySelectorAll('.tx-simplequiz-ajax').forEach((element) => {
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
