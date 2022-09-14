const { render } = wp.element;
import Filter from "./components/Filter";

const filterContainer = document.getElementById("wif_filter");
if (filterContainer) {
  if (window.wif?.structure) {
    render(
      <Filter
        structure={window.wif.structure}
        initialFilters={window.wif?.initialFilters}
      />,
      filterContainer
    );
  }
}
