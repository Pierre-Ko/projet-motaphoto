document.addEventListener('DOMContentLoaded', function() {
    // Get the modal
    var modal = document.getElementById('myModal');
  
    // Get the button that opens the modal
    var openModalBtn = document.getElementById('openModalLink');
    var closeModalBtn = document.getElementById('closeModalBtn');
  
    // Function to open the modal
    function openModal() {
      if (modal) {
        modal.style.display = 'block';
      }
    }
  
    // Function to close the modal
    function closeModal() {
      if (modal) {
        modal.style.display = 'none';
      }
    }
  
    // Attach event listener to open the modal if the button exists
    if (openModalBtn) {
      openModalBtn.addEventListener('click', openModal);
    }
  
    // Attach event listener to close the modal if the button exists
    if (closeModalBtn) {
      closeModalBtn.addEventListener('click', closeModal);
    }
  
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (modal && event.target == modal) {
        closeModal();
      }
    };
});