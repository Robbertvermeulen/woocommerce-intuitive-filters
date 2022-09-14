const { useState } = wp.element;

const FilterDropdown = ({ name, options, value, changeHandler }) => {
  const [collapsed, setCollapsed] = useState(true);

  const handleClick = () => {
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
          <span className="wif-filter__select-placeholder">
            Placeholder text
          </span>
        )}
      </div>

      {!collapsed && (
        <div className="wif-filter__select-dropdown">
          {options?.map((option) => (
            <div
              className="wif-filter__select-dropdown-option"
              onClick={() => handleOptionClick(option.value)}
            >
              {option?.label.toLowerCase()}
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default FilterDropdown;
