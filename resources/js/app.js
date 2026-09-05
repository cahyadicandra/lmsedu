import './bootstrap';

// Alpine Persist plugin must be registered BEFORE alpine loads
import Alpine from 'alpinejs';
import Persist from '@alpinejs/persist';

Alpine.plugin(Persist);
window.Alpine = Alpine;
Alpine.start();
