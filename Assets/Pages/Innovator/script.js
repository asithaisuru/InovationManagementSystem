function genarateResponse() {
  alert(
    "Please wait while we generate the tasks for you. If you have disabled pop-ups, please enable them for this site."
  );
  const description = document.getElementById("pdis").value;
  if (description === "") {
    alert("Please enter the project description");
    return;
  }
  fetch("server.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ description }),
  })
    .then((response) => response.json())
    .then((data) => {
      // Open a new window to display the response
      const content =
        "<head>" +
        "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>" +
        "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>" +
        "<title>Generated Tasks</title>" +
        "</head>" +
        "<body class='bg-dark text-white'>" +
        "<div class='container'>" +
        "<h1 class='text-center mb-5 mt-5'>AI Generated Tasks</h1>" +
        "<pre>" +
        data.tasks +
        "</pre>" +
        "</div>" +
        "</body>";

      const responseWindow = window.open(
        "",
        "_blank",
        `width=${window.innerWidth},height=400`
      );
      responseWindow.document.write(content);
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
