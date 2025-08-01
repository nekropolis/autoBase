import DOMPurify from "dompurify";
import {DescriptionItem} from "@/pages/Knowledge/DescriptionItem";

type Props = {
    instructions: any[];
};

export default function InstructionList({instructions}: Props) {
    return (
        <div className="space-y-4">
            {instructions.length ? instructions.map((instruction) => (
                <div key={instruction.id} className="mb-6 p-4 border rounded shadow-sm">
                    <div className="relative mb-2">
                        <h2 className="text-lg font-semibold pr-6">
                            {instruction.title}
                        </h2>

                        {/* Иконка справа от заголовка на мобильных */}
                        <span className="absolute right-0 top-0 sm:hidden">📄</span>

                        {/* Бейдж с текстом — только на больших экранах */}
                        <span className="hidden sm:inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary text-primary-foreground absolute right-0 top-0">
                            📄 Инструкции
                        </span>
                    </div>

                    <DescriptionItem description={instruction.content} />

                    {instruction.source && (
                        <div className="mt-2">
                            <strong>Источник:</strong>
                            <ul className="list-disc text-sm ml-0 sm:ml-5">
                                <li>
                                    <a href={instruction.source.url} className="text-blue-600 hover:underline" target="_blank">
                                        {instruction.source.type}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    )}
                </div>
            )) : <p>Ничего не найдено</p>}
        </div>
    );
}
