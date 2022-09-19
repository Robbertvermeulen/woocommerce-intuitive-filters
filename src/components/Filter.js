const { useState, useEffect } = wp.element;
import axios from "axios";
import qs from "qs";
import FilterDropdown from "./FilterDropdown";

const isObjectEmpty = (object) => {
  return object && Object.keys(object).length;
};

const Filter = ({ filterId, structure, initialFilters }) => {
  const [filters, setFilters] = useState(
    (isObjectEmpty(initialFilters) && initialFilters) || {}
  );
  const [submitReady, setSubmitReady] = useState(false);
  const [showReset, setShowReset] = useState(false);

  useEffect(() => {
    if (isObjectEmpty(filters)) {
      setSubmitReady(true);
      setShowReset(true);
    }
  }, [filters]);

  const changeHandler = (name, value) => {
    setShowReset(true);
    setFilters((prevState) => ({ ...prevState, [name]: value }));
  };

  const handleResetClick = () => {
    setFilters({});
    setShowReset(false);
    setSubmitReady(false);
  };

  const handleSubmit = async () => {
    if (submitReady) {
      try {
        const response = await axios.post(
          window.wif_plugin.ajaxUrl,
          qs.stringify({
            action: "handle_submit_filter",
            filters,
            filter_id: filterId,
          })
        );
        if (response.data.redirect_url) {
          window.location.replace(response.data.redirect_url);
        }
      } catch (err) {
        console.error(err);
      }
    }
  };

  return (
    <div className="wif-filter">
      <div style={{ marginBottom: "1.875em" }}>
        {structure?.map((element, i) => {
          if (!element.type) return;
          switch (element.type) {
            case "text":
              return (
                <span className="wif-filter__text">{element?.content}</span>
              );
            case "dropdown":
              return (
                <FilterDropdown
                  key={i}
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
      <button
        className="wif-filter__submit"
        disabled={!submitReady}
        onClick={handleSubmit}
      >
        Bekijk resultaten
      </button>
      {showReset && (
        <div>
          <span className="wif-filter__reset" onClick={handleResetClick}>
            Begin opnieuw
          </span>
        </div>
      )}
    </div>
  );
};

export default Filter;
