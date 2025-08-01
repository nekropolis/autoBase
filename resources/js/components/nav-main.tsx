import {
    SidebarGroup,
} from '@/components/ui/sidebar';
import {useKnowledgeFiltersContext} from "@/context/KnowledgeFiltersContext";

export function NavMain() {
    const { formData, setFormData, brands, models, modifications, handleSearch, resetFilters } = useKnowledgeFiltersContext();

    return (
        <SidebarGroup className="px-2 py-0">
            <div className="grid grid-cols-2 gap-4">
                <div>
                    <select
                        value={formData.brand_id}
                        onChange={e => setFormData(fd => ({ ...fd, brand_id: e.target.value }))}
                        className="mt-1 block w-full border rounded p-2"
                    >
                        <option value="">Марка</option>
                        {brands.map((b: any) => (
                            <option key={b.id} value={b.id}>{b.name}</option>
                        ))}
                    </select>
                </div>

                <div>
                    <select
                        value={formData.model_id}
                        onChange={e => setFormData(fd => ({ ...fd, model_id: e.target.value }))}
                        disabled={!formData.brand_id}
                        className={`mt-1 block w-full border rounded p-2 transition ${
                            !formData.brand_id ? 'opacity-50 cursor-not-allowed' : ''
                        }`}
                    >
                        <option value="">Модель</option>
                        {models.map((m: any) => (
                            <option key={m.id} value={m.id}>{m.name}</option>
                        ))}
                    </select>
                </div>

                <div>
                    <select
                        value={formData.modification_id}
                        onChange={e => setFormData(fd => ({ ...fd, modification_id: e.target.value }))}
                        disabled={!formData.model_id}
                        className={`mt-1 block w-full border rounded p-2 transition ${
                            !formData.model_id ? 'opacity-50 cursor-not-allowed' : ''
                        }`}
                    >
                        <option value="">Модификация</option>
                        {modifications.map((m: any) => (
                            <option key={m.id} value={m.id}>{m.name}</option>
                        ))}
                    </select>
                </div>

                <div>
                    <select
                        value={formData.search_type}
                        onChange={e => setFormData(fd => ({ ...fd, search_type: e.target.value }))}
                        className={`mt-1 block w-full border rounded p-2 transition ${
                            !formData.model_id ? 'opacity-50 cursor-not-allowed' : ''
                        }`}
                        disabled={!formData.model_id}
                    >
                        <option value="">Все статьи</option>
                        <option value="problems">Проблемы</option>
                        <option value="instructions">Инструкции</option>
                    </select>
                </div>

                <div className="col-span-2">
                    <input
                        type="text"
                        placeholder="Введите запрос для поиска"
                        className="mt-1 block w-full border rounded p-2"
                        value={formData.part}
                        onChange={e => setFormData(fd => ({ ...fd, part: e.target.value }))}

                    />
                </div>

                <div className="col-span-1">
                    <button
                        onClick={handleSearch}
                        className="w-full bg-blue-600 text-white py-2 rounded
                        hover:bg-blue-700 transition disabled:bg-gray-400
                        disabled:cursor-not-allowed disabled:hover:bg-gray-400"
                        disabled={!modifications.length}
                    >
                        Найти
                    </button>
                </div>
                <div className="col-span-1">
                    <button
                        onClick={resetFilters}
                        className="w-full bg-gray-200 text-gray-800 py-2 rounded hover:bg-gray-300
                        disabled:bg-gray-400 disabled:cursor-not-allowed disabled:hover:bg-gray-400 transition"
                        disabled={!modifications.length}
                    >
                        Очистить
                    </button>
                </div>
            </div>
        </SidebarGroup>
    );
}
