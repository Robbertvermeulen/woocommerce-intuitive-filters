const { useState } = wp.element;

const FilterDropdown = ({ name, options, value, changeHandler }) => {
  const [collapsed, setCollapsed] = useState(true);

  // Order options so selected option is first
  options?.sort((x, y) => (x.value === value ? -1 : y.value === value ? 1 : 0));

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
    <div className="wif-filter__select-container" onClick={handleClick}>
      <div className="wif-filter__select">
        {(value && getSelectedOptionLabel()?.toLowerCase()) || (
          <span className="wif-filter__select-placeholder">Placeholder</span>
        )}
      </div>

      {!collapsed && (
        <div className="wif-filter__select-dropdown">
          {options?.map((option, i) => {
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
