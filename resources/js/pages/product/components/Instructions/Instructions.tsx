import * as React from "react";
import { pdfIcon } from "../../../../ui/Icons/Icons";
interface IInstructions {
    instructions: TInstruction[];
}

type TInstruction = {
    description: string;
    file_link: string;
};

function Instructions({ instructions }: IInstructions) {
    return (
        <ul className="instructions-list">
            {instructions.map((item: TInstruction) => (
                <li key={item.description}>
                    <a
                        target="_blank"
                        href={item.file_link}
                        title={item.description}
                    >
                        {pdfIcon}
                        <span>{item.description}</span>
                    </a>
                </li>
            ))}
        </ul>
    );
}

export default React.memo(Instructions);
