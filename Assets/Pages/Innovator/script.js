function genarateResponse() {
  const description = document.getElementById("pdis").value;
  if (description === "") {
    alert("Please enter the project description");
    return;
  }

  alert(
    "Please wait while we generate the tasks for you. If you have disabled pop-ups, please enable them for this site."
  );

  fetch("server.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ description }),
  })
    .then((response) => response.json())
    .then((data) => {
      // new window to display the response
      const content =
        "<head>" +
        "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>" +
        "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>" +
        "<title>Generated Tasks</title>" +
        "</head>" +
        "<body class='bg-dark text-white'>" +
        "<div class='container'>" +
        "<div class='mt-2 p-3 bg-primary text-white rounded'>" +
        "<img class='card-img-top mx-auto d-block' src='../../img/LogoWhite.png' alt='Logo' style='width:150px;height:150px;'>" +
        '<div class="my-3">' +
        '<h1 class="text-center">Innovation Management System</h1>' +
        '<p class="text-center display-6"><small>Step into the new world</small></p>' +
        "</div>" +
        "</div>" +
        "<h1 class='text-center mb-4 mt-5'>AI Generated Tasks</h1>" +
        "<div>" +
        data.tasks +
        "</div>" +
        "</div>" +
        "</body>";

      const responseWindow = window.open(
        "",
        "_blank",
        `width=${window.innerWidth}`
      );
      responseWindow.document.write(content);
    })
    .catch((error) => {
      alert("Error: " + error);
      console.error("Error:", error);
    });
}
