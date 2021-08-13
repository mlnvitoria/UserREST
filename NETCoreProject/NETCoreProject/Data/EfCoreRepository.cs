using Microsoft.EntityFrameworkCore;
using NETCoreProject.Data.Interfaces;
using NETCoreProject.Models;
using System.Threading.Tasks;

namespace NETCoreProject.Data
{
    public abstract class EfCoreRepository<TEntity> : IRepository<TEntity>
        where TEntity : class, IEntity
    {
        protected readonly ProjectDbContext Context;
        protected readonly DbSet<TEntity> DbSet;

        public EfCoreRepository(ProjectDbContext context)
        {
            Context = context;
            DbSet = Context.Set<TEntity>();
        }

        public async Task<TEntity> GetById(int id)
        {
            return await DbSet.FindAsync(id);
        }

        public async Task<TEntity> Create(TEntity entity)
        {
            entity.CreatedAt = System.DateTime.Now;
            entity.UpdatedAt = System.DateTime.Now;
            entity.DeletedAt = null;
            DbSet.Add(entity);
            await Context.SaveChangesAsync();

            return entity;
        }

        public async Task<TEntity> Update(TEntity entity)
        {
            entity.UpdatedAt = System.DateTime.Now;
            Context.Entry(entity).State = EntityState.Modified;
            await Context.SaveChangesAsync();

            return entity;
        }

        public async Task<TEntity> DeleteById(int id)
        {
            var entity = await DbSet.FindAsync(id);
            if (entity == null)
            {
                return entity;
            }

            entity.DeletedAt = System.DateTime.Now;
            Context.Entry(entity).State = EntityState.Modified;
            await Context.SaveChangesAsync();

            return entity;
        }

    }
}
