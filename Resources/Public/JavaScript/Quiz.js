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
            if (data.html) {
              this.containerElement.innerHTML = data.html;
            }
          });
        } else {
          console.error('Error in simple quiz form ajax request. Status: ' + response.status);
        }
      });
    });
  }
}
