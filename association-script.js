// association-script.js


const associationsData = [
  {
    id: 1,
    nom: "Association Solidarité Maroc",
    description: "Aide alimentaire et soutien aux personnes défavorisées",
    avatar: "/placeholder.svg?height=80&width=80",
  },
  {
    id: 2,
    nom: "Jeunesse et Avenir",
    description: "Éducation et accompagnement des jeunes",
    avatar: "/placeholder.svg?height=80&width=80",
  },
  {
    id: 3,
    nom: "Environnement Vert",
    description: "Protection de l'environnement et sensibilisation",
    avatar: "/placeholder.svg?height=80&width=80",
  },
  {
    id: 4,
    nom: "Santé Communautaire",
    description: "Amélioration de l'accès aux soins de santé",
    avatar: "/placeholder.svg?height=80&width=80",
  },
]

// Variables globales
let currentFilter = "tous"
let currentSearchTerm = ""
let currentTab = "publications"

// Initialisation
document.addEventListener("DOMContentLoaded", () => {
  initializeEventListeners()
  renderPublications()
  renderAssociations()
})

// Event listeners
function initializeEventListeners() {
  // Gestion des onglets
  const tabTriggers = document.querySelectorAll(".tab-trigger")
  tabTriggers.forEach((trigger) => {
    trigger.addEventListener("click", function () {
      const tabName = this.dataset.tab
      switchTab(tabName)
    })
  })

  // Gestion de la recherche
  const searchInput = document.getElementById("searchInput")
  searchInput.addEventListener("input", function () {
    currentSearchTerm = this.value.toLowerCase()
    filterAndRender()
  })

  // Gestion du filtre
  const filterSelect = document.getElementById("filterSelect")
  filterSelect.addEventListener("change", function () {
    currentFilter = this.value
    filterAndRender()
  })

  // Bouton "Charger plus"
  const loadMoreBtn = document.querySelector(".load-more-btn")
  loadMoreBtn.addEventListener("click", () => {
    loadMorePublications()
  })
}

// Gestion des onglets








  // Ajouter les event listeners pour les actions
  const likeBtn = card.querySelector(".like-btn")
  likeBtn.addEventListener("click", function () {
    toggleLike(publication.id, this)
  })

  const commentBtn = card.querySelector(".comment-btn")
  commentBtn.addEventListener("click", () => {
    openComments(publication.id)
  })

  return card


// Rendu des associations
function renderAssociations() {
  const container = document.getElementById("associationsGrid")
  const filteredData = filterAssociations()

  container.innerHTML = ""

  filteredData.forEach((association, index) => {
    const associationElement = createAssociationCard(association, index)
    container.appendChild(associationElement)
  })
}

// Filtrage des associations
function filterAssociations() {
  return associationsData.filter((association) => {
    return (
      association.nom.toLowerCase().includes(currentSearchTerm) ||
      association.description.toLowerCase().includes(currentSearchTerm)
    )
  })
}

// Création d'une carte d'association
function createAssociationCard(association, index) {
  const card = document.createElement("div")
  card.className = "card association-card fade-in"
  card.style.animationDelay = `${index * 0.1}s`

  card.innerHTML = `
        <div class="card-content">
            <div class="association-avatar">
                <img src="${association.avatar}" alt="Logo association" />
            </div>
            <h3>${association.nom}</h3>
            <p class="description">${association.description}</p>
            <button class="btn btn-sm btn-full" data-id="${association.id}">
                <i class="fas fa-users"></i>
                Voir le profil
            </button>
        </div>
    `

  // Ajouter l'event listener pour voir le profil
  const profileBtn = card.querySelector(".btn")
  profileBtn.addEventListener("click", () => {
    viewProfile(association.id)
  })

  return card
}

// Actions
function toggleLike(publicationId, button) {
  const publication = publicationsData.find((p) => p.id === publicationId)
  if (publication) {
    publication.likes += button.classList.contains("liked") ? -1 : 1
    button.classList.toggle("liked")
    button.querySelector("span").textContent = publication.likes

    // Animation
    button.style.transform = "scale(1.2)"
    setTimeout(() => {
      button.style.transform = "scale(1)"
    }, 150)
  }
}

function openComments(publicationId) {
  console.log("Ouvrir les commentaires pour la publication:", publicationId)
  // Ici vous pouvez implémenter l'ouverture d'une modal de commentaires
}

function viewProfile(associationId) {
  console.log("Voir le profil de l'association:", associationId)
  // Ici vous pouvez implémenter la navigation vers le profil
}

function loadMorePublications() {
  const button = document.querySelector(".load-more-btn")
  button.textContent = "Chargement..."
  button.classList.add("loading")

  // Simuler un chargement
  setTimeout(() => {
    // Ici vous pouvez charger plus de données depuis votre API
    button.textContent = "Charger plus"
    button.classList.remove("loading")
  }, 1000)
}

// Utilitaires
function debounce(func, wait) {
  let timeout
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout)
      func(...args)
    }
    clearTimeout(timeout)
    timeout = setTimeout(later, wait)
  }
}

// Optimisation de la recherche avec debounce
const debouncedSearch = debounce(filterAndRender, 300)

// Remplacer l'event listener de recherche
document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("searchInput")
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      currentSearchTerm = this.value.toLowerCase()
      debouncedSearch()
    })
  }
})
