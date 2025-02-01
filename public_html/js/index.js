// AUTO/PISTA
let carouselContainer,
  slides,
  currentSlide,
  carouselButtons,
  selectionButtons,
  choiceContainer,
  currentCircuit,
  choiceGallery,
  circuitSlides,
  dateChoiceContainer;
// AREA RISERVATA
let reservedAreaMenuContainer,
  reservedAreaContainer,
  addModelContainer,
  addCircuitContainer,
  liList,
  buttonList,
  sectionList;

// CONTATTACI
let contactUsForm,
  contactUsName,
  contactUsSurname,
  contactUsEmail,
  contactUsMessage;

// HAMBURGER MENU
let hamburger, navMenu;

// LOGIN
let loginForm, loginUsername, loginPassword;

// SIGN UP
let signUpForm,
  signUpUsername,
  signUpName,
  signUpSurname,
  signUpEmail,
  signUpBirth,
  signUpPassword;

//RECAP
let dateContainerChildren,
  dateChoice,
  dateSelected,
  bookingDetailsContainer,
  bookingInfo,
  bookingPrice,
  lapNumber;

/* ******* INITIALIZATION *******/
function initPage() {
  initMobileView();
  initTornaSu();
}

/* ********** HAMBURGER MENU ********** */
function initMobileView() {
  hamburger = document.querySelector(".hamburger");
  navMenu = document.querySelector(".nav-menu");
  hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
  });

  document.querySelectorAll(".nav-link").forEach((n) =>
    n.addEventListener("click", () => {
      hamburger.classList.remove("active");
      navMenu.classList.remove("active");
    })
  );
}

/* *********** TORNA SU ********** */
function initTornaSu() {
  var ua = window.navigator.userAgent;
  var iOS = /iP(ad|hone)/i.test(ua);
  var webkit = /AppleWebKit/i.test(ua);
  var iOSSafari = iOS && webkit && !/CriOS/i.test(ua);

  if (!iOSSafari)
    document.documentElement.classList.add("scroll-behaviour-smooth");

  const tornaSu = document.getElementById("torna-su");
  tornaSu.classList.add("hidden")

  window.addEventListener("scroll", () => {
    if (
      document.body.scrollTop > 300 ||
      document.documentElement.scrollTop > 300
    ) {
      tornaSu.classList.remove("hidden");
    } else {
      tornaSu.classList.add("hidden");
    }
  });
}

/*  **********  AUTO/PISTA ********** */
function initCarousel() {
  initPage();

  carouselContainer = document.getElementById("carousel-image-list");

  carouselButtons = document.getElementById("carousel-buttons");
  selectionButtons = carouselButtons.getElementsByTagName("button");

  choiceGallery = document.getElementById("choice-gallery");

  slides = carouselContainer.getElementsByTagName("li");

  const controlButtons = carouselButtons.getElementsByTagName("button");
  for (let i = 0; i < controlButtons.length; i++)
    controlButtons[i].addEventListener("click", () => {
      changeSlide(i);
    });

  choiceContainer = document.getElementById("choice-container");
  circuitSlides = choiceContainer.querySelectorAll("li[data-slide]");

  dateChoiceContainer = document.getElementById("date-choice-container");

  document.getElementById("button-container").classList.add("hidden");

  currentSlide = 0;
  currentCircuit = 0;
}

function nextSlide() {
  if (currentSlide + 1 !== slides.length) updateSlides(currentSlide + 1);
  else updateSlides(0);
}

function prevSlide() {
  if (currentSlide === 0) updateSlides(slides.length - 1);
  else updateSlides(currentSlide - 1);
}

function changeSlide(newSlide) {
  if (currentSlide !== newSlide) updateSlides(newSlide);
}

function updateSlides(newSlide) {
  slides[currentSlide].classList.add("hidden");
  slides[currentSlide].setAttribute("tabindex", "-1");
  slides[newSlide].classList.remove("hidden");
  slides[currentSlide].removeAttribute("tabindex");
  updateButtons(newSlide);
}

function updateButtons(newSlide) {
  selectionButtons[currentSlide].classList.remove("current");
  selectionButtons[currentSlide].removeAttribute("aria-current");
  selectionButtons[newSlide].classList.add("current");
  selectionButtons[newSlide].setAttribute("aria-current", "true");
  currentSlide = newSlide;
}

function setChoice(e) {
  e = e || window.event;
  var targ = e.target || e.srcElement || e;
  if (targ.nodeType == 3) targ = targ.parentNode;

  document.getElementById(
    "choice-display"
  ).innerHTML = `Hai scelto: <span class="nome-pista">${targ.value}</span>`;

  document.getElementById("button-container").classList.remove("hidden");
}

function validateChoice() {
  const inputList = choiceContainer.querySelectorAll("input");
  ok = false;
  for (let i = 0; i < inputList.length; i++)
    if (inputList[i].checked) ok = true;
  if (!ok) setError(choiceContainer, "Seleziona uno");
  return ok;
}

/* ********* CONTATTACI ********* */
function initContattaci() {
  initPage();
  contactUsForm = document.getElementById("form-contacts");
  contactUsName = document.getElementById("contact-us-nome");
  contactUsSurname = document.getElementById("contact-us-cognome");
  contactUsEmail = document.getElementById("contact-us-email");
  contactUsMessage = document.getElementById("contact-us-message");

  contactUsForm.addEventListener("submit", (e) => {
    e.preventDefault();
    validateContactUsInputs();
  });
}

const setError = (element, message) => {
  const inputControl = element.parentElement;
  const errorDisplay =
    inputControl.querySelector(".error") ||
    inputControl.querySelector(".error-message");

  errorDisplay.innerText = message;
  inputControl.classList.add("error");
  inputControl.classList.remove("success");
  if (errorDisplay.classList.contains("hidden"))
    errorDisplay.classList.remove("hidden");
};

const setSuccess = (element) => {
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector(".error");

  errorDisplay.innerText = "";
  inputControl.classList.add("success");
  inputControl.classList.remove("error");
};

const isValidEmail = (contactUsEmail) => {
  const re =
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(contactUsEmail).toLowerCase());
};

const validateContactUsInputs = () => {
  const nameValue = contactUsName.value.trim();
  const cognomeValue = contactUsSurname.value.trim();
  const emailValue = contactUsEmail.value.trim();
  const messageValue = contactUsMessage.value.trim();

  if (nameValue === "") {
    setError(contactUsName, "Campo obbligatorio!");
  } else {
    setSuccess(contactUsName);
  }

  if (cognomeValue === "") {
    setError(contactUsSurname, "Campo obbligatorio!");
  } else {
    setSuccess(contactUsSurname);
  }

  if (emailValue === "") {
    setError(contactUsEmail, "Campo obbligatorio!");
  } else if (!isValidEmail(emailValue)) {
    setError(contactUsEmail, "Il formato non è valido.");
  } else {
    setSuccess(contactUsEmail);
  }

  if (messageValue === "") {
    setError(contactUsMessage, "Il testo del messaggio non può essere vuoto!");
  } else {
    setSuccess(contactUsMessage);
  }
};

/* ******** LOGIN *********/
function initLogin() {
  initPage();

  loginForm = document.getElementById("login");
  loginUsername = document.getElementById("username");
  loginPassword = document.getElementById("password");

  loginForm.addEventListener("submit", (e) => {
    if (!validateLoginInputs()) {
      e.preventDefault();
    }
  });
}

const validateLoginInputs = () => {
  const usernameValue = loginUsername.value.trim();
  const passwordValue = loginPassword.value.trim();

  ok = true;

  if (usernameValue === "") {
    setError(loginUsername, "Campo obbligatorio!");
    ok = false;
  } else {
    setSuccess(loginUsername);
  }

  if (passwordValue === "") {
    setError(loginPassword, "Campo obbligatorio!");
    ok = false;
  } else {
    setSuccess(loginPassword);
  }

  return ok;
};

/* ********* SIGN UP **********/
function initSignUp() {
  initPage();

  signUpForm = document.getElementById("signup");
  signUpUsername = document.getElementById("sign-up-username");
  signUpName = document.getElementById("sign-up-nome");
  signUpSurname = document.getElementById("sign-up-cognome");
  signUpEmail = document.getElementById("sign-up-mail");
  signUpBirth = document.getElementById("sign-up-nascita");
  signUpPassword = document.getElementById("sign-up-password");

  signUpForm.addEventListener("submit", (e) => {
    if (!validateSignUpInputs()) {
      e.preventDefault();
    }
  });
}

const validateSignUpInputs = () => {
  const usernameValue = signUpUsername.value.trim();
  const nameValue = signUpName.value.trim();
  const cognomeValue = signUpSurname.value.trim();
  const mailValue = signUpEmail.value.trim();
  const nascitaValue = signUpBirth.value.trim();
  const passwordValue = signUpPassword.value.trim();

  ok = true;

  if (usernameValue === "") {
    setError(signUpUsername, "Campo obbligatorio!");
    ok = false;
  } else {
    setSuccess(signUpUsername);
  }

  if (nameValue === "") {
    setError(signUpName, "Campo obbligatorio!");
    ok = false;
  } else {
    setSuccess(signUpName);
  }
  if (cognomeValue === "") {
    setError(signUpSurname, "Campo obbligatorio!");
    ok = false;
  } else {
    setSuccess(signUpSurname);
  }

  if (mailValue === "") {
    setError(signUpEmail, "Campo obbligatorio!");
  } else {
    setSuccess(signUpEmail);
  }

  if (nascitaValue === "") {
    setError(signUpBirth, "Campo obbligatorio!");
    ok = false;
  } else {
    setSuccess(signUpBirth);
  }

  if (passwordValue === "") {
    setError(signUpPassword, "Campo obbligatorio!");
    ok = false;
  } else {
    setSuccess(signUpPassword);
  }
  return ok;
};

/* ********* AREA RISERVATA  ********** */
function initReservedArea() {
  initPage();

  reservedAreaMenuContainer = document.getElementById("area-riservata-menu");
  reservedAreaContainer = document.getElementById("area-riservata-container");
  addModelContainer = document.getElementById("aggiungi-macchina-container");
  addCircuitContainer = document.getElementById("aggiungi-pista-container");
  sectionList = reservedAreaContainer.children;
  liList = reservedAreaMenuContainer.children;
  buttonList = [];
  for (let i = 0; i < liList.length; i++)
    buttonList.push(liList[i].children[0]);

  if(document.getElementById("add-modello-container"))  
    document.getElementById("add-modello-container").classList.add("hidden")
  if(document.getElementById("add-pista-container"))
    document.getElementById("add-pista-container").classList.add("hidden")
  if(document.getElementById("lista-prenotazioni"))
    document.getElementById("lista-prenotazioni").classList.add("hidden")

  if (window.location.href.includes("section")) {
    const path = window.location.href.split("section=")[1].split("&")[0].split("#")[0];
    switch (path) {
      case "modello":
        showSection("add-modello-container");
        break;
      case "pista":
        showSection("add-pista-container");
        break;
      case "prenotazioni":
        showSection("lista-prenotazioni");
        break;
    }
  }
}

function validateAnagraficaInput() {
  const anagraficaName = document.getElementById("anagrafica-nome");
  const anagraficaSurname = document.getElementById("anagrafica-cognome");
  const anagraficaEmail = document.getElementById("anagrafica-mail");
  const anagraficaBirth = document.getElementById("anagrafica-nascita");

  const nameValue = anagraficaName.value.trim();
  const surnameValue = anagraficaSurname.value.trim();
  const emailValue = anagraficaEmail.value.trim();
  const birthValue = anagraficaBirth.value.trim();

  ok = true;

  if (nameValue === "") {
    setError(anagraficaName, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(anagraficaName);
  if (surnameValue === "") {
    setError(anagraficaSurname, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(anagraficaSurname);
  if (emailValue === "") {
    setError(anagraficaEmail, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(anagraficaEmail);
  if (birthValue === "") {
    setError(anagraficaBirth, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(anagraficaBirth);

  return ok;
}

function validateAddModelInput() {
  const modelName = document.getElementById("modello-nome");
  const modelCategory = document.getElementById("modello-categoria");
  const modelDescription = document.getElementById("modello-descrizione");
  const modelKmCost = document.getElementById("modello-costo_km");
  const modelSpecName = document.getElementById("modello-specifica-nome");
  const modelSpecValue = document.getElementById("modello-specifica-valore");
  const modelImage = document.getElementById("modello-immagine");
  const modelAlt = document.getElementById("modello-immagine-alt");

  const nameValue = modelName.value.trim();
  const categoryValue = modelCategory.value.trim();
  const descriptionValue = modelDescription.value.trim();
  const kmCostValue = modelKmCost.value.trim();
  const specNameValue = modelSpecName.value.trim();
  const specValueValue = modelSpecValue.value.trim();
  const imageList = modelImage.files;
  const altValue = modelAlt.value.trim();

  ok = true;

  if (nameValue === "") {
    setError(modelName, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(modelName);
  if (categoryValue === "") {
    setError(modelCategory, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(modelCategory);
  if (descriptionValue === "") {
    setError(modelDescription, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(modelDescription);
  if (kmCostValue === "") {
    setError(modelKmCost, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(modelKmCost);
  if (specNameValue === "") {
    setError(modelSpecName, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(modelSpecName);
  if (specValueValue === "") {
    setError(modelSpecValue, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(modelSpecValue);
  if (imageList.length === 0) {
    setError(modelImage, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(modelImage);
  if (altValue === "") {
    setError(modelAlt, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(modelAlt);

  return ok;
}

function validateAddCircuitInput() {
  const circuitName = document.getElementById("pista-nome");
  const circuitDistrict = document.getElementById("pista-provincia");
  const circuitDescription = document.getElementById("pista-descrizione");
  const circuitFixedCost = document.getElementById("pista-costo_fisso");
  const circuitLength = document.getElementById("pista-lunghezza");
  const circuitWidth = document.getElementById("pista-larghezza");
  const circuitNumberOfCurves = document.getElementById("pista-n-curve");
  const circuitGradient = document.getElementById("pista-dislivello");
  const circuitStraightLength = document.getElementById("pista-rettilineo");
  const circuitImage = document.getElementById("pista-immagine");
  const circuitAlt = document.getElementById("pista-immagine-alt");

  const nameValue = circuitName.value.trim();
  const districtValue = circuitDistrict.value.trim();
  const descriptionValue = circuitDescription.value.trim();
  const fixedCostValue = circuitFixedCost.value.trim();
  const lengthValue = circuitLength.value.trim();
  const widthValue = circuitWidth.value.trim();
  const numberOfCurvesValue = circuitNumberOfCurves.value.trim();
  const gradientValue = circuitGradient.value.trim();
  const straigthLengthValue = circuitStraightLength.value.trim();
  const imageList = circuitImage.files;
  const altValue = circuitAlt.value.trim();

  ok = true;

  if (nameValue === "") {
    setError(circuitName, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(circuitName);
  if (districtValue === "") {
    setError(circuitDistrict, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(circuitDistrict);
  if (descriptionValue === "") {
    setError(circuitDescription, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(circuitDescription);
  if (fixedCostValue === "") {
    setError(circuitFixedCost, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(circuitFixedCost);
  if (lengthValue === "") {
    setError(circuitLength, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(circuitLength);
  if (widthValue === "") {
    setError(circuitWidth, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(circuitWidth);
  if (numberOfCurvesValue === "") {
    setError(circuitNumberOfCurves, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(circuitNumberOfCurves);
  if (gradientValue === "") {
    setError(circuitGradient, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(circuitGradient);
  if (straigthLengthValue === "") {
    setError(circuitStraightLength, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(circuitStraightLength);
  if (imageList.length === 0) {
    setError(circuitImage, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(circuitImage);
  if (altValue === "") {
    setError(circuitAlt, "Campo obbligatorio!");
    ok = false;
  } else setSuccess(circuitAlt);

  return ok;
}

function hideCurrentSection() {
  buttonList.map((button, index) => {
    if (button.disabled) {
      button.disabled = false;
      liList[index].setAttribute("aria-selected", "false");

      const controlledSectionId = liList[index].getAttribute("aria-controls");
      let controlledSection;
      for (let i = 0; i < sectionList.length; i++) {
        if (sectionList[i].id === controlledSectionId)
          controlledSection = sectionList[i];
      }
      controlledSection.setAttribute("aria-hidden", "true");
      controlledSection.setAttribute("aria-expanded", "false");
      controlledSection.classList.add("hidden");
    }
  });
}

function showSection(id) {
  hideCurrentSection();
  for (let i = 0; i < liList.length; i++) {
    if (liList[i].getAttribute("aria-controls") === id) {
      buttonList[i].disabled = true;
      liList[i].setAttribute("aria-selected", "true");
    }

    if (sectionList[i].id === id) {
      sectionList[i].setAttribute("aria-hidden", "false");
      sectionList[i].setAttribute("aria-expanded", "true");
      sectionList[i].classList.remove("hidden");
    }
  }
}

function addImageToModel() {
  const imgLabelDiv = document.createElement("div");
  imgLabelDiv.classList.add("grid-item");
  const imgLabelLabel = document.createElement("label");
  imgLabelLabel.setAttribute(
    "for",
    `modello-galleria${addModelContainer.children.length}`
  );
  imgLabelLabel.innerText = "Immagine della galleria";
  imgLabelDiv.appendChild(imgLabelLabel);

  const imgInputDiv = document.createElement("div");
  imgInputDiv.classList.add("grid-item");
  imgInputDiv.classList.add("input-row");
  const imgInputInput = document.createElement("input");
  imgInputInput.setAttribute("type", "file");
  imgInputInput.setAttribute("name", "galleria[]");
  imgInputInput.setAttribute(
    "id",
    `modello-galleria${addModelContainer.children.length}`
  );
  imgInputDiv.appendChild(imgInputInput);

  const altLabelDiv = document.createElement("div");
  altLabelDiv.classList.add("grid-item");
  const altLabelLabel = document.createElement("label");
  altLabelLabel.setAttribute(
    "for",
    `modello-galleria-alt${addModelContainer.children.length}`
  );
  altLabelLabel.innerText = "Testo alternativo all'immagine di galleria";
  altLabelDiv.appendChild(altLabelLabel);

  const altInputDiv = document.createElement("div");
  altInputDiv.classList.add("grid-item");
  altInputDiv.classList.add("input-row");
  const altInputInput = document.createElement("input");
  altInputInput.setAttribute("type", "text");
  altInputInput.setAttribute("name", "galleria_alt[]");
  altInputInput.setAttribute(
    "id",
    `modello-galleria-alt${addModelContainer.children.length}`
  );
  altInputDiv.appendChild(altInputInput);

  const target = addModelContainer.querySelectorAll("span")[1];
  target.parentNode.insertBefore(imgLabelDiv, target);
  target.parentNode.insertBefore(imgInputDiv, target);
  target.parentNode.insertBefore(altLabelDiv, target);
  target.parentNode.insertBefore(altInputDiv, target);
}

function addImageToCircuit() {
  const imgLabelDiv = document.createElement("div");
  imgLabelDiv.classList.add("grid-item");
  const imgLabelLabel = document.createElement("label");
  imgLabelLabel.setAttribute(
    "for",
    `pista-galleria${addCircuitContainer.children.length}`
  );
  imgLabelLabel.innerText = "Immagine della galleria";
  imgLabelDiv.appendChild(imgLabelLabel);

  const imgInputDiv = document.createElement("div");
  imgInputDiv.classList.add("grid-item");
  imgInputDiv.classList.add("input-row");
  const imgInputInput = document.createElement("input");
  imgInputInput.setAttribute("type", "file");
  imgInputInput.setAttribute("name", "galleria[]");
  imgInputInput.setAttribute(
    "id",
    `pista-galleria${addCircuitContainer.children.length}`
  );
  imgInputDiv.appendChild(imgInputInput);

  const altLabelDiv = document.createElement("div");
  altLabelDiv.classList.add("grid-item");
  const altLabelLabel = document.createElement("label");
  altLabelLabel.setAttribute(
    "for",
    `pista-galleria-alt${addCircuitContainer.children.length}`
  );
  altLabelLabel.innerText = "Testo alternativo all'immagine di galleria";
  altLabelDiv.appendChild(altLabelLabel);

  const altInputDiv = document.createElement("div");
  altInputDiv.classList.add("grid-item");
  altInputDiv.classList.add("input-row");
  const altInputInput = document.createElement("input");
  altInputInput.setAttribute("type", "text");
  altInputInput.setAttribute("name", "galleria_alt[]");
  altInputInput.setAttribute(
    "id",
    `pista-galleria-alt${addCircuitContainer.children.length}`
  );
  altInputDiv.appendChild(altInputInput);

  const target = addCircuitContainer.querySelector("span");
  target.parentNode.insertBefore(imgLabelDiv, target);
  target.parentNode.insertBefore(imgInputDiv, target);
  target.parentNode.insertBefore(altLabelDiv, target);
  target.parentNode.insertBefore(altInputDiv, target);
}

function addSpecs() {
  const nameLabelDiv = document.createElement("div");
  nameLabelDiv.classList.add("grid-item");
  const nameLabelLabel = document.createElement("label");
  nameLabelLabel.innerText = "Nome specifica(<abbr title='massimo'>max</abbr> 64 caratteri)";
  nameLabelLabel.setAttribute(
    "for",
    `modello-specifica-nome${addCircuitContainer.children.length}`
  );
  nameLabelDiv.appendChild(nameLabelLabel);

  const nameInputDiv = document.createElement("div");
  nameInputDiv.classList.add("grid-item");
  nameInputDiv.classList.add("input-row");
  const nameInputInput = document.createElement("input");
  nameInputInput.setAttribute("type", "text");
  nameInputInput.setAttribute("name", "specifica_nome[]");
  nameInputInput.setAttribute(
    "id",
    `modello-specifica-nome${addCircuitContainer.children.length}`
  );
  nameInputDiv.appendChild(nameInputInput);

  const valueLabelDiv = document.createElement("div");
  valueLabelDiv.classList.add("grid-item");
  const valueLabelLabel = document.createElement("label");
  valueLabelLabel.innerText = "Valore";
  valueLabelLabel.setAttribute(
    "for",
    `modello-specifica-valore${addCircuitContainer.children.length}`
  );
  valueLabelDiv.appendChild(valueLabelLabel);

  const valueInputDiv = document.createElement("div");
  valueInputDiv.classList.add("grid-item");
  valueInputDiv.classList.add("input-row");
  const valueInputInput = document.createElement("input");
  valueInputInput.setAttribute("type", "text");
  valueInputInput.setAttribute("name", "specifica_valore[]");
  valueInputInput.setAttribute(
    "id",
    `modello-specifica-valore${addCircuitContainer.children.length}`
  );
  valueInputDiv.appendChild(valueInputInput);

  const target = addModelContainer.querySelectorAll("span")[0];
  target.parentNode.insertBefore(nameLabelDiv, target);
  target.parentNode.insertBefore(nameInputDiv, target);
  target.parentNode.insertBefore(valueLabelDiv, target);
  target.parentNode.insertBefore(valueInputDiv, target);
}

function conferma(prenotazione) {
  return confirm(
    `Vuoi cancellare la prenotazione del ${new Date(
      prenotazione.ora_inizio
    ).toLocaleString()}
Destinatario: ${prenotazione.destinatario.nome} ${
      prenotazione.destinatario.cognome
    }
Pista: ${prenotazione.pista}
Auto: ${prenotazione.modello}`
  );
}

/* ******** RECAP ********* */
function initRecap() {
  initPage();

  dateSelected = document.getElementById("date-selected");
  dateChoice = document.getElementById("date-choice");
  bookingDetailsContainer = document.getElementById(
    "booking-details-container"
  );
  bookingInfo = document.getElementById("booking-info");
  bookingPrice = document.getElementById("booking-price");
  lapNumber = document.getElementById("lap-number");

  dateSelected.min = new Date()
    .toISOString()
    .split("T")[0];
}

function validateRecap() {
  ok = true;

  if (dateSelected.value === "") {
    setError(dateSelected, "Seleziona la data");
    ok = false;
  }

  let turnCheck = [];
  dateChoice
    .querySelectorAll("input[type='radio']")
    .forEach((input) => turnCheck.push(input.checked));
  turnCheck = turnCheck.reduce((prev, next) => prev || next);
  if (!turnCheck) {
    setError(dateChoice, "Seleziona il turno");
    ok = false;
  }

  if(lapNumber.value === ""){
    setError(lapNumber, "Numero di giri richiesto")
    ok = false
  }

  return ok;
}

function updateDate() {
  bookingInfo.getElementsByTagName("p")[2].innerHTML = `Data: ${new Date(
    dateSelected.value
  ).toLocaleDateString()}`;
}

function setTurno() {
  bookingInfo.getElementsByTagName(
    "p"
  )[3].innerHTML = `Fascia oraria: ${dateChoice
    .querySelector('input[name="turno"]:checked')
    .getAttribute("data-value")
    .replace("-", " - ")}`;
}

function stepDown() {
  if (lapNumber.value > 4) lapNumber.value--;
  bookingInfo.getElementsByTagName(
    "p"
  )[4].innerHTML = `Numero di giri: ${lapNumber.value}`;

  lapNumber.onchange();
}

function stepUp() {
  if (lapNumber.value < 10) lapNumber.value++;
  bookingInfo.getElementsByTagName(
    "p"
  )[4].innerHTML = `Numero di giri: ${lapNumber.value}`;

  lapNumber.onchange();
}

function updatePrice(costo_km, costo_fisso, lunghezza_pista) {
  bookingPrice.getElementsByTagName("p")[1].innerHTML = `${(
    costo_fisso +
    lapNumber.value * costo_km * lunghezza_pista
  ).toFixed(2)}€`;
}
