import React, { createContext, useContext, useState, useEffect, ReactNode } from 'react';
import {router} from "@inertiajs/react";

type KnowledgeFilterData = {
    brand_id: string;
    model_id: string;
    modification_id: string;
    search_type: string;
    part: string;
};

type Item = { id: string; name: string };

type KnowledgeFiltersContextType = {
    formData: KnowledgeFilterData;
    setFormData: React.Dispatch<React.SetStateAction<KnowledgeFilterData>>;
    brands: Item[];
    models: Item[];
    modifications: Item[];
    selectedBrand: Item | null;
    selectedModel: Item | null;
    selectedModification: Item | null;
    resetFilters: () => void;
    handleSearch: () => void;
};

const KnowledgeFiltersContext = createContext<KnowledgeFiltersContextType | undefined>(undefined);

export function KnowledgeFiltersProvider({ children }: { children: ReactNode }) {
    const [brands, setBrands] = useState<Item[]>([]);
    const [models, setModels] = useState<Item[]>([]);
    const [modifications, setModifications] = useState<Item[]>([]);

    const [formData, setFormData] = useState<KnowledgeFilterData>({
        brand_id: '',
        model_id: '',
        modification_id: '',
        search_type: '',
        part: '',
    });

    // Загрузка брендов при инициализации
    useEffect(() => {
        fetch('/api/brands').then(res => res.json()).then(setBrands);
    }, []);

    // Загрузка моделей при выборе бренда
    useEffect(() => {
        if (formData.brand_id) {
            fetch(`/api/models?brand_id=${formData.brand_id}`).then(res => res.json()).then(setModels);
        } else {
            setModels([]);
        }
        // Сбросим модель и модификацию, если бренд изменился
        setFormData(fd => ({ ...fd, model_id: '', modification_id: '' }));
        setModifications([]);
    }, [formData.brand_id]);

    // Загрузка модификаций при выборе модели
    useEffect(() => {
        if (formData.model_id) {
            fetch(`/api/modifications?model_id=${formData.model_id}`).then(res => res.json()).then(setModifications);
        } else {
            setModifications([]);
        }
        // Сброс модификации, если модель изменилась
        setFormData(fd => ({ ...fd, modification_id: '' }));
    }, [formData.model_id]);

    const selectedBrand = brands.find(b => String(b.id) === formData.brand_id) ?? null;
    const selectedModel = models.find(m => String(m.id) === formData.model_id) ?? null;
    const selectedModification = modifications.find(m => String(m.id) === formData.modification_id) ?? null;

    const resetFilters = () => {
        setFormData({
            brand_id: '',
            model_id: '',
            modification_id: '',
            search_type: '',
            part: '',
        });
        setModels([]);
        setModifications([]);

        router.get('/', {}, {
            preserveState: false,
            preserveScroll: true,
        });
    };

    const handleSearch = () => {
        console.log(modifications, formData.modification_id);
        if (formData.model_id == '') {
            return;
        }
        router.get('/', {
            brand_id: formData.brand_id || '',
            model_id: formData.model_id || '',
            modification_id: formData.modification_id || '',
            search_type: formData.search_type || '',
            part: formData.part || '',
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    return (
        <KnowledgeFiltersContext.Provider
            value={{
                formData,
                setFormData,
                brands,
                models,
                modifications,
                selectedBrand,
                selectedModel,
                selectedModification,
                resetFilters,
                handleSearch,
            }}
        >
            {children}
        </KnowledgeFiltersContext.Provider>
    );
}

export function useKnowledgeFiltersContext() {
    const context = useContext(KnowledgeFiltersContext);
    if (!context) {
        throw new Error('useKnowledgeFiltersContext must be used within KnowledgeFiltersProvider');
    }
    return context;
}
