import "./bootstrap";
import "flowbite";


import Alpine from "alpinejs";
import chart01 from './chart/chart-one';
chart01();
import chartCustomer from './chart/chart-customer';
chartCustomer();


window.Alpine = Alpine;

Alpine.start();
