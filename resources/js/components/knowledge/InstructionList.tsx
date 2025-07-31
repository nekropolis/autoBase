import DOMPurify from "dompurify";

type Props = {
    instructions: any[];
};

export default function InstructionList({instructions}: Props) {
    return (
        <div className="space-y-4">
            {instructions.length
                ? instructions.map((instruction) => (
                    <div key={instruction.id} className="mb-6 p-4 border rounded shadow-sm">
                        <div className="flex items-center justify-between">
                            <h2 className="text-lg font-semibold">{instruction.title}</h2>
                            <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary text-primary-foreground">
                                📄 Инструкции
                            </span>
                        </div>
                        <div
                            className="text-sm text-gray-700"
                            dangerouslySetInnerHTML={{
                                __html: DOMPurify.sanitize(instruction.content),
                            }}
                        />
                        {instruction.source && (
                            <div className="mt-2">
                                <strong>Источник:</strong>
                                <ul className="list-disc ml-5 text-sm">
                                    <li>{instruction.source.url}</li>
                                </ul>
                            </div>
                        )}
                    </div>
                ))
                : <p>Ничего не найдено</p>}
        </div>
    );
}
