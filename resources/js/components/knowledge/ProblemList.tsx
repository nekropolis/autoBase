type Props = {
    problems: any[];
};

export default function ProblemList({ problems }: Props) {
    return (
        <div className="space-y-4">
            {problems.length
                ? problems.map((problem) => (
                    <div key={problem.id} className="mb-6 p-4 border rounded shadow-sm">
                        <div className="flex items-center justify-between">
                            <h2 className="text-lg font-semibold">{problem.title}</h2>
                            <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary text-primary-foreground">
                                🛠️ Проблема · {problem.solutions.length} решений
                            </span>
                        </div>

                        <p className="text-sm text-gray-700">{problem.description}</p>

                        {problem.solutions.length > 0 && (
                            <div className="mt-2">
                                <strong>Решения:</strong>
                                <ul className="list-disc ml-5 text-sm">
                                    {problem.solutions.map((s: any) => (
                                        <li key={s.id}>{s.description}</li>
                                    ))}
                                </ul>
                            </div>
                        )}

                        {problem.sources.length > 0 && (
                            <div className="mt-2">
                                <strong>Источник:</strong>
                                <ul className="list-disc ml-5 text-sm">
                                    {problem.sources.map((s: any) => (
                                        <li key={s.id}>{s.url}</li>
                                    ))}
                                </ul>
                            </div>
                        )}
                    </div>
                   ))
                : <p>Ничего не найдено</p>
            }
        </div>
    );
}
