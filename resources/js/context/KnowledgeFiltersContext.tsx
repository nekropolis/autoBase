import React, {createContext, useContext, useState, useEffect, ReactNode, useRef} from 'react';
import { router } from "@inertiajs/react";

type KnowledgeFilterData = {
    brand_id: string;
    model_id: string;
    modification_id: string;
    search_type: string;
    part: string;
    header: string;
};

type Item = { id: string; name: string };

type KnowledgeFiltersContextType = {
    formData: KnowledgeFilterData;
    setFormData: React.Dispatch<React.SetStateAction<KnowledgeFilterData>>;
    brands: Item[];
    models: Item[];
    modifications: Item[];
    resetFilters: () => void;
    handleSearch: () => void;
};

const KnowledgeFiltersContext = createContext<KnowledgeFiltersContextType | undefined>(undefined);

export function KnowledgeFiltersProvider({
                                             children,
                                             initialFilters = {},
                                         }: {
    children: ReactNode;
    initialFilters?: Partial<KnowledgeFilterData>;
}) {
    const [brands, setBrands] = useState<Item[]>([]);
    const [models, setModels] = useState<Item[]>([]);
    const [modifications, setModifications] = useState<Item[]>([]);
    const prevBrandIdRef = useRef<string | undefined>(undefined);
    const prevModelIdRef = useRef<string | undefined>(undefined);

    const [formData, setFormData] = useState<KnowledgeFilterData>({
        brand_id: initialFilters.brand_id || '',
        model_id: initialFilters.model_id || '',
        modification_id: initialFilters.modification_id || '',
        search_type: initialFilters.search_type || '',
        part: initialFilters.part || '',
        header: initialFilters.header || '',
    });

    useEffect(() => {
        fetch('/api/brands').then(res => res.json()).then(setBrands);
    }, []);

    useEffect(() => {
        if (formData.brand_id) {
            fetch(`/api/models?brand_id=${formData.brand_id}`)
                .then(res => res.json())
                .then(setModels);
        } else {
            setModels([]);
        }

        if (prevBrandIdRef.current !== undefined && prevBrandIdRef.current !== formData.brand_id) {
            setFormData(fd => ({
                ...fd,
                model_id: '',
                modification_id: ''
            }));
            setModifications([]);
        }

        prevBrandIdRef.current = formData.brand_id;
    }, [formData.brand_id]);

    useEffect(() => {
        if (formData.model_id) {
            fetch(`/api/modifications?model_id=${formData.model_id}`)
                .then(res => res.json())
                .then(setModifications);
        } else {
            setModifications([]);
        }

        if (prevModelIdRef.current !== undefined && prevModelIdRef.current !== formData.model_id) {
            setFormData(fd => ({
                ...fd,
                modification_id: ''
            }));
        }

        prevModelIdRef.current = formData.model_id;
    }, [formData.model_id]);

    useEffect(() => {
        if (initialFilters.header) {
            setFormData(fd => ({
                ...fd,
                header: initialFilters.header || '',
            }));
        }
    }, [initialFilters.header]);

    const resetFilters = () => {
        setFormData({
            brand_id: '',
            model_id: '',
            modification_id: '',
            search_type: '',
            part: '',
            header: '',
        });
        setModels([]);
        setModifications([]);

        router.get('/', {}, {
            preserveState: false,
            preserveScroll: true,
        });
    };

    const handleSearch = () => {
        if (formData.model_id == '') {
            return;
        }
        router.get('/', {
            brand_id: formData.brand_id || '',
            model_id: formData.model_id || '',
            modification_id: formData.modification_id || '',
            search_type: formData.search_type || '',
            part: formData.part || '',
            header: formData.header || '',
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
