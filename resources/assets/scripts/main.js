// import external dependencies
import 'jquery';
import 'slick-carousel/slick/slick';

import { library, dom } from '@fortawesome/fontawesome-svg-core';
import {faShoppingCart, faSearch} from '@fortawesome/free-solid-svg-icons';
library.add(faShoppingCart, faSearch);
dom.watch();
// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import myAccount from './routes/my-account';
/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
  // My Account page
  myAccount,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());