const { useState, useRef, useEffect } = wp.element;

const FilterDropdown = ({ name, options, value, changeHandler }) => {
  const ref = useRef(null);
  const [collapsed, setCollapsed] = useState(true);

  // Order options so selected option is first
  if (options && options.length > 0)
    options?.sort((x, y) =>
      x.value === value ? -1 : y.value === value ? 1 : 0
    );

  useEffect(() => {
    const handleClickOutside = (event) => {
      if (ref.current && !ref.current.contains(event.target) && !collapsed)
        setCollapsed(true);
    };
    document.addEventListener("mousedown", handleClickOutside);
    return () => {
      document.removeEventListener("mousedown", handleClickOutside);
    };
  }, [ref, collapsed]);

  const handleClick = (e) => {
    setCollapsed(!collapsed);
  };

  const handleOptionClick = (value) => {
    changeHandler(name, value);
  };

  const getSelectedOption = () => {
    return value && options.find((option) => option.value === value);
  };

  const getSelectedOptionLabel = () => {
    const selectedOption = getSelectedOption();
    return selectedOption?.label;
  };

  return (
    <div
      ref={ref}
      className="wif-filter__select-container"
      onClick={handleClick}
    >
      <div className="wif-filter__select">
        {(value && getSelectedOptionLabel()?.toLowerCase()) || (
          <span className="wif-filter__select-placeholder">Placeholder</span>
        )}
      </div>

      {!collapsed && (
        <div className="wif-filter__select-dropdown">
          {options &&
            options.length > 0 &&
            options.map((option, i) => {
              const classNames = ["wif-filter__select-dropdown-option"];
              if (option.value === value)
                classNames.push("wif-filter__select-dropdown-option--selected");
              return (
                <div
                  key={i}
                  className={classNames.join(" ")}
                  onClick={() => handleOptionClick(option.value)}
                >
                  {option?.label.toLowerCase()}
                </div>
              );
            })}
        </div>
      )}
    </div>
  );
};

export default FilterDropdown;
