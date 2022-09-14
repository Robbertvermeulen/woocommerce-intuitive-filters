const { useState } = wp.element;
import FilterDropdown from "./FilterDropdown";

const Filter = ({ structure }) => {
  const [filters, setFilters] = useState({});
  const [submitReady, setSubmitReady] = useState(false);

  const changeHandler = (name, value) => {
    setFilters((prevState) => ({ ...prevState, [name]: value }));
  };

  return (
    <div className="wif-filter">
      <div style={{ marginBottom: "1.875em" }}>
        {structure?.map((element) => {
          if (!element.type) return;
          switch (element.type) {
            case "text":
              return (
                <span className="wif-filter__text">{element?.content}</span>
              );
            case "dropdown":
              return (
                <FilterDropdown
                  name={element.name}
                  options={element.options}
                  changeHandler={changeHandler}
                  value={filters[element.name] || null}
                />
              );
            default:
              return;
          }
        })}
      </div>
      <button className="wif-filter__submit" disabled={!submitReady}>
        Bekijk resultaten
      </button>
      <div>
        <span className="wif-filter__reset">Begin opnieuw</span>
      </div>
    </div>
  );
};

export default Filter;
