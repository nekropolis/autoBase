import {DescriptionItem} from "@/pages/Knowledge/DescriptionItem";

type Props = {
    problems: any[];
};

export default function ProblemList({ problems }: Props) {
    return (
        <div className="space-y-4">
            {problems.length ? problems.map((problem) => (
                <div key={problem.id} className="mb-6 p-4 border rounded shadow-sm">
                    <div className="relative mb-2">
                        <h2 className="text-lg font-semibold pr-6">
                            {problem.title}
                        </h2>

                        {/* Иконка справа от заголовка на мобильных */}
                        <span className="absolute right-0 top-0 sm:hidden">🛠️</span>

                        {/* Бейдж с текстом — только на больших экранах */}
                        <span className="hidden sm:inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary text-primary-foreground absolute right-0 top-0">
                            🛠️ Проблема · {problem.solutions.length} решений
                        </span>
                    </div>

                    <DescriptionItem description={problem.description} />

                    {problem.solutions.length > 0 && (
                        <div className="mt-2">
                            <strong>Решения:</strong>
                            <ul className="list-disc text-sm ml-0 sm:ml-5">
                                {problem.solutions.map((s: any) => (
                                    <DescriptionItem key={s.id} description={s.description} />
                                ))}
                            </ul>
                        </div>
                    )}

                    {problem.sources.length > 0 && (
                        <div className="mt-2">
                            <strong>Источник:</strong>
                            <ul className="list-disc text-sm ml-0 sm:ml-5">
                                {problem.sources.map((s: any) => (
                                    <li key={s.id}>
                                        <a href={s.url} className="text-blue-600 hover:underline" target="_blank">
                                            {s.type}
                                        </a>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}
                </div>
            )) : <p>Ничего не найдено</p>}
        </div>
    );
}
