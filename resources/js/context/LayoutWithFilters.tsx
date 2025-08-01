import { KnowledgeFiltersProvider } from '@/context/KnowledgeFiltersContext';
import { usePage } from '@inertiajs/react';
import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { KnowledgeFilterData } from "@/hooks/types/knowledge-filters";

interface PageProps extends InertiaPageProps {
    filters?: Partial<KnowledgeFilterData>;
}

export default function LayoutWithFilters({ children }: { children: React.ReactNode }) {
    const { filters = {} } = usePage<PageProps>().props;

    return (
        <KnowledgeFiltersProvider initialFilters={filters}>
            {children}
        </KnowledgeFiltersProvider>
    );
}
