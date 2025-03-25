class Quiz
{
  constructor(formElement, containerElement) {
    this.formElement = formElement;
    this.containerElement = containerElement;
    this.convertFormSubmitToAjax();
  }

  convertFormSubmitToAjax() {
    this.formElement.addEventListener('submit', (event) => {
      event.preventDefault();

      window.fetch(
        this.formElement.getAttribute('action'),
        {
          method: "POST",
          body: new FormData(this.formElement),
        }
      ).then((response) => {
        if (response.ok) {
          response.json().then((data) => {
            if (!data.hasErrors && data.html) {
              this.containerElement.innerHTML = data.html;
            } else if (data.hasErrors && data.html) {
              this.showErrorMessage(data.html);
            } else {
              alert('An unexpected error occurred. Please restart the quiz again.');
            }
          });
        } else {
          console.error('Error in simple quiz form ajax request. Status: ' + response.status);
        }
      });
    });
  }

  showErrorMessage(html) {
    let errorContainer = this.containerElement.querySelector('.tx-simplequiz-errors');

    if (errorContainer) {
      errorContainer.innerHTML = html;
      errorContainer.classList.add('show');
    } else {
      console.error(html);
    }
  }
}
