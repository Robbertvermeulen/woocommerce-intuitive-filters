const { render } = wp.element;
import Filter from "./components/Filter";

const filterContainer = document.getElementById("wif_filter");
if (filterContainer) {
  if (window.wif) {
    render(<Filter structure={window.wif} />, filterContainer);
  }
}
