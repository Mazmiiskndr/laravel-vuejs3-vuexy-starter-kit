import { setupLayouts } from 'virtual:generated-layouts'
import { createRouter, createWebHistory } from 'vue-router'
import routes from '~pages'
import titles from '../../js/navigation/vertical/index'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    ...setupLayouts(routes),
  ],
})

router.beforeEach((to, from, next) => {
  // Find the route in `titles` that matches the name of the route we're navigating to
  const matchingTitleRoute = titles.find(titleRoute => titleRoute.to.name === to.name)
  
  // If a matching route is found in `titles`, set the document title to its title
  if (matchingTitleRoute) {
    document.title = matchingTitleRoute.title
  } else {
    // If no matching route is found, set a default title
    document.title = 'Default Title'
  }
  
  next()
})

export default router
