import * as React from 'react';

const Accordion = ({ title, text }) => {
  const [isOpen, setIsOpen] = React.useState<boolean>(false);

  // eslint-disable-next-line @typescript-eslint/explicit-function-return-type
  const toggling = () => setIsOpen(!isOpen);
  return (
    <div className="accordion">
      <div className={`accordion_head ${isOpen ? 'accordion_head--active' : ''.trim()}`} onClick={toggling}>
        {title}
        <img className={`accordion_icon ${isOpen ? 'accordion_icon--active' : ''.trim()}`} alt="#" src="/img/plus-icon.svg" />
      </div>
      {isOpen && (
        <div className={`accordion_content ${isOpen ? 'accordion_content--active' : ''.trim()}`}>
          <p dangerouslySetInnerHTML={{ __html: text }} />
        </div>
      )}
    </div>
  );
};

export default Accordion;
